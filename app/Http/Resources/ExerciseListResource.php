<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class ExerciseListResource extends JsonResource
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
            'name' => $this->name,
            'body_part' => $this?->body_part?->name,
            'exercise_style' => $this?->exercise_style?->name,
            'sets' => $this->sets,
            'reps' => $this->reps,
            'rest' => $this->rest,
            'weight' => $this->weight,
            'tempo' => $this->tempo,
            'intensity' => $this->intensity,
            'notes' => $this->notes,
            'video_link' => $this->video_link,
            'image' => $this->image ? URL::to($this->image) : null,
        ];
    }
}
