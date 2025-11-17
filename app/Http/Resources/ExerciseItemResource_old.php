<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;


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

        // Only if user relation is loaded, fetch the log data
        if ($showLogData) {
            $user = $request->user(); // Get the logged-in user

            // Fetch the log for the current exercise item for the user
            $log = $user->exerciseLogs()
                ->where('new_item_id', $this->id)
                ->first(); // Get the log if it exists

            // Determine if the exercise is logged
            $isLogged = $log ? true : false;

            // Prepare log data
            $logData = $log ? [
                'sets' => $log->sets,
                'reps' => $log->reps,
                'weight' => $log->weight,
                'logged_at' => $log->created_at->format('Y-m-d H:i:s'),
                'notes' => $log->notes,
                'swapped' => $log->replaced_item_id ? true : false,
                'replaced_item' => $log->replacedExerciseItem ? [
                    'id' => $log->replacedExerciseItem->id,
                    'name' => $log->replacedExerciseItem->name,
                ] : null,
            ] : null;
        }
        // Return the JSON response
        return [
            'id' => $this->id,
            'name' => $this?->exercise_list?->name, // Show original or swapped item name
            'sets' => $this->sets,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'tempo' => $this->tempo,
            'intensity' => $this->intensity,
            'notes' => $this->notes,
            'video_link' => $this?->exercise_list?->video_link ? URL::to($this?->exercise_list?->video_link) : null,
            'image' => $this?->exercise_list?->image ? URL::to($this?->exercise_list?->image) : null,
            // Conditionally include logs and swap data if the user relation is loaded
            'is_logged' => $showLogData ? $isLogged : null, // Show logged status only if with user relation
            'log_data' => $showLogData ? $logData : null, // Show log details only if with user relation
        ];

    }
}
