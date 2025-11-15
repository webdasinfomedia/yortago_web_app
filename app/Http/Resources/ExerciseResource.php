<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $isFavourite = $this->favouriteExercise()->where('user_id', $request->user()->id)->exists();
        return [
            'id' => $this->id,
            //get id of
            'program_id' => $this?->pivot?->id,
            'image' => $this->image ? URL::to($this->image) : null,
            'phase' => "1 - " . count($this->weeks),
            'title' => $this->title,
            'age' => $this->age?->age_range,
            'gender' => $this->gender?->name,
            'experience_level' => $this->experience_level?->heading . "" . $this->experience_level?->sub_heading,
            'equipment_name' => $this->equipment?->name,
            'category_name' => $this->category?->name,
            'youtube_playlist_link'=>$this->youtube_link,
            'is_favourite' => $isFavourite,
            'weeks' => $this->weeks->each(function ($week, $index) {
                // Attach index to each week
                $week->index = $index;
                $week->program_id = $this?->pivot?->id;
            })->map(function ($week) {
                return new WeekResource($week);
            })
        ];
    }

}
