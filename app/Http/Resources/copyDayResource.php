<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class DayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    // public function toArray($request)
    // {
    //     return [
    //         'id' => $this->id,
    //         'title' => $this->title,
    //         'summary' => $this->summary,
    //         'duration' => $this->duration,
    //         'day_number' => $this->when(isset($this->index), $this->index + 1),
    //         'program_id' => $this->when(isset($this->program_id), $this->program_id),
    //         //'exercise_items' => ExerciseItemResource::collection($this->exerciseItems),
    //         'exercise_items' => $this->exerciseItems->each(function ($day, $index) {
    //             // Attach index to each day within the week
    //             $day->index = $index;
    //             $day->program_id = $this->program_id;
    //         })->map(function ($day) {
    //             return new ExerciseItemResource($day); // Pass each day to the DayResource
    //         }),
    //     ];
    // }
    
     public function toArray($request)
    {
        // Map exercise items and calculate status
        $exerciseItems = $this->exerciseItems->each(function ($day, $index) {
            $day->index = $index;
            $day->program_id = $this->program_id;
        })->map(function ($day) {
            return new ExerciseItemResource($day);
        });

        // Calculate day status based on exercise completion
        $dayStatus = $this->calculateDayStatus($exerciseItems);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'duration' => $this->duration,
            'day_number' => $this->when(isset($this->index), $this->index + 1),
            'program_id' => $this->when(isset($this->program_id), $this->program_id),
            'status' => $dayStatus,
            'exercise_items' => $exerciseItems,
        ];
    }

    
     /**
     * Calculate the status of the day based on exercise completion
     *
     * @param \Illuminate\Support\Collection $exerciseItems
     * @return string
     */
    private function calculateDayStatus($exerciseItems)
    {
        // Filter out exercises with null names (incomplete/placeholder exercises)
        $validExercises = $exerciseItems->filter(function ($item) {
            $itemArray = $item->resolve();
            return !empty($itemArray['name']);
        });

        $totalExercises = $validExercises->count();
        
        if ($totalExercises === 0) {
            return 'pending';
        }

        // Count completed exercises
        $completedCount = $validExercises->filter(function ($item) {
            // Convert resource to array to access data
            $itemArray = $item->resolve();
            
            // Check if exercise has log data with completed status
            return isset($itemArray['log_data']) && 
                   $itemArray['log_data'] !== null && 
                   isset($itemArray['log_data']['status']) && 
                   $itemArray['log_data']['status'] === 'completed';
        })->count();

        // Determine day status
        if ($completedCount === 0) {
            return 'pending';
        } elseif ($completedCount === $totalExercises) {
            return 'completed';
        } else {
            return 'in_progress';
        }
    }
   

}
