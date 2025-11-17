<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\URL;

class FavouriteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'program_id' => $this?->pivot?->id,
            'image' => $this->image ? URL::to($this->image) : null,
            
            'name' => $this->name,
            'sets' => $this->sets,
            'reps' => $this->reps,
            'weight' => $this->weight,
            'rest' => $this->rest,
            'video_link' => $this->video_link,
            'body_part' => $this->body_part
        ];
    }
}

