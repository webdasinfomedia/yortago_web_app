<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TestingResource extends JsonResource
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
            'trail1' => $this->trail1,
            'trail2' => $this->trail2,
            'trail3' => $this->trail3,
            'calories_burned' => $this->calories_burn,
            //get avaerage of all trails
            'avg_of_trails' => ($this->trail1 + $this->trail2 + $this->trail3) / 3,
            'created_at' => $this->created_at,
        ];
    }
}
