<?php

namespace App\Http\Resources;

use App\Models\NewExerciseWeekDayItem;
use App\Models\NewUserExerciseLog;
use App\Models\User;
use App\Models\Favourite;
use App\Models\UserSwap;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;
use App\Models\AlternateExerciseList;


class ExerciseItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // Check if the request is with the user relation
        $showLogData = $request->get('show_logs', false); // Loads logs only if the user relation is loaded
        // Initialize log-related variables
        $log = null;
        $isLogged = false;
        $logData = null;
        $checkIfSwapped = null;
        $idNeadToBeSearchedInLog = null;

        

            $user = $request->user(); // Get the logged-in user
            //check if item swapped
            $checkIfSwapped = UserSwap::where('user_id', $user->id)
                ->where('exercise_item_id', $this->id)
                ->where('new_user_exercise_id', $this->program_id)
                ->first();
            if($checkIfSwapped){
                $idNeadToBeSearchedInLog = NewExerciseWeekDayItem::with(array('exercise_list'))->where('id',$checkIfSwapped->new_item_id)->first();
            }else{
                $idNeadToBeSearchedInLog = $this;
            }

            $favourite = Favourite::where(['user_id' => auth()->user()->id, 'exercise_id' => $idNeadToBeSearchedInLog?->exercise_list?->id ])->first();
            $isFav = false;
            if($favourite){
                $isFav = true;
            }
            $log = $user->exerciseLogs()
                ->where('new_item_id', $idNeadToBeSearchedInLog->id)
                ->first(); // Get the log if it exists

            // Determine if the exercise is logged
            $isLogged = $log ? true : false;

            // Prepare log data
            $logData = $log ? [
                 'sets' => $this->decodeArrayValue($log->sets),
                'reps' => $this->decodeArrayValue($log->reps),
                'weight' => $this->decodeArrayValue($log->weight),
                'logged_at' => $log->created_at->format('Y-m-d H:i:s'),
                'notes' => $log->notes,
                'intensity' => $log->intensity,
                'time_taken' => $log->time_taken,
                'weight_unit' => $log->weight_unit,
                'status' => $log->status,
                'alternate'=>(bool) $log->alternate,
                'alternate_exercise_id' => $log->alternate_exercise_id ? (int) $log->alternate_exercise_id : null,
                'swapped' => $log->replaced_item_id ? true : false,
                'replaced_item' => $log->replacedExerciseItem ? [
                    'id' => $log->replacedExerciseItem->id,
                    'name' => $log->replacedExerciseItem->name,
                ] : null,
            ] : null;
        // Check if alternate exercises exist
        $alternateExercises = [];
        if ($idNeadToBeSearchedInLog->exercise_list_id) {
            $alternateExercises = AlternateExerciseList::where('exercise_list_id', $idNeadToBeSearchedInLog->exercise_list_id)->where('new_exercise_week_day_item_id', $idNeadToBeSearchedInLog->id)
                ->get();
        }

        // Return the JSON response
        return [
            'id' => $idNeadToBeSearchedInLog->id,
            'program_id' => $this->when(isset($this->program_id), $this->program_id),
            'is_swapped' => $checkIfSwapped ? true : false,
            'body_part' => $idNeadToBeSearchedInLog?->exercise_list?->body_part?->name,
            'body_part_id' => $idNeadToBeSearchedInLog?->exercise_list?->body_part_id,
            'exercise_style' => $idNeadToBeSearchedInLog?->exercise_list?->exercise_style?->name,
            'name' => $idNeadToBeSearchedInLog?->exercise_list?->name, // Show original or swapped item name
            'exercise_list_item_id' => $idNeadToBeSearchedInLog?->exercise_list?->id,
            'is_fav' => $isFav,
            'sets' => $idNeadToBeSearchedInLog->sets,
            'reps' => $idNeadToBeSearchedInLog->reps,
            'weight' => $idNeadToBeSearchedInLog->weight,
            'weight_value'=>$idNeadToBeSearchedInLog->weight_value ?? null,
            'tempo' => $idNeadToBeSearchedInLog->tempo,
            'intensity' => $idNeadToBeSearchedInLog->intensity,
            'notes' => $idNeadToBeSearchedInLog->notes,
            'rest' => $this->rest,
            'video_link' => $idNeadToBeSearchedInLog?->exercise_list?->video_link,
            'image' => $idNeadToBeSearchedInLog?->exercise_list?->image ? URL::to($this?->exercise_list?->image) : null,
            'alternate_exercises' => AlternateExerciseListResource::collection($alternateExercises),
            // Conditionally include logs and swap data if the user relation is loaded
            'is_logged' => $isLogged, // Show logged status only if with user relation
            'log_data' =>  $logData , // Show log details only if with user relation
        ];

    }
    private function decodeArrayValue($value)
{
    // Try to decode JSON first (e.g. "[1,2,3]" → [1,2,3])
    $decoded = json_decode($value, true);

    // If it’s valid JSON and returns an array, use that
    if (is_array($decoded)) {
        return $decoded;
    }

    // Otherwise, clean manually: remove brackets and explode by comma
    $cleaned = trim($value, "[]");
    if ($cleaned === '') {
        return [];
    }

    // Convert each element to number or string as needed
    return array_map('trim', explode(',', $cleaned));
}

}
