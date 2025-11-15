<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class AlternateExerciseListResource extends JsonResource
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
            'exercise_list_id' => $this->exercise_list_id,
            'new_exercise_week_day_item_id' => $this->new_exercise_week_day_item_id,
            'name' => $this->name,
            'body_part' => $this->bodyPart?->name ?? null,
            'body_part_id' => $this->body_part_id,
            'exercise_style' => $this->exerciseStyle?->name ?? null,
            'exercise_style_id' => $this->exercise_style_id,
            'sets' => $this->sets,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'weight_value' => $this->weight_value,
            'rest' => $this->rest,
            'tempo' => $this->tempo,
            'intensity' => $this->intensity,
            'video_link' => $this->video_link,
            'notes' => $this->notes,
            'image' => $this->image ? URL::to($this->image) : null,
        ];
    }
}