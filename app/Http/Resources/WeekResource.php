<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeekResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'week_number' => $this->when(isset($this->index), $this->index + 1),
            'program_id' => $this->when(isset($this->program_id), $this->program_id),
            'days' => $this->days->each(function ($day, $index) {
                // Attach index to each day within the week
                $day->index = $index;
                $day->program_id = $this->program_id;
            })->map(function ($day) {
                return new DayResource($day); // Pass each day to the DayResource
            }),
        ];
    }
}
