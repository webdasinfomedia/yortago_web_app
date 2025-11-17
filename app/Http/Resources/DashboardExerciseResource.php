<?php

namespace App\Http\Resources;
use Illuminate\Support\Facades\URL;

use Illuminate\Http\Resources\Json\JsonResource;

class DashboardExerciseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    
       public function toArray($request)
        {
            $status = !empty($this->pivot->completion_date) ? "completed" : "incomplete";

            return [
                'id' => $this->id,
                'type'=>$this->type, 
                'program_id' => $this?->pivot?->id,
                'start_date' => $this->pivot->start_date ?? null,
                'completion_date' => $this->pivot->completion_date ?? null,
                'status' => $status,
                'image' => $this->image ? URL::to($this->image) : null,
                'phase' => "1 - " . count($this->weeks),
                'title' => $this->title,
                'age' => $this->age?->age_range,
                'gender' => $this->gender?->name,
                'experience_level' => $this->experience_level?->heading . "" . $this->experience_level?->sub_heading,
                'equipment_name' => $this->equipment?->name,
                'category_name' => $this->category?->name,
                'youtube_playlist_link'=>$this->youtube_link,
            ];
        }
    
}
