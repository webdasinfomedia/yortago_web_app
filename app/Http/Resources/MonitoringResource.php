<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MonitoringResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $setRep = 0;

        // Decode JSON if necessary
        $this->sets = is_string($this->sets) ? json_decode($this->sets, true) : $this->sets;
        $this->reps = is_string($this->reps) ? json_decode($this->reps, true) : $this->reps;
        $this->weight = is_string($this->weight) ? json_decode($this->weight, true) : $this->weight;
        
        // Ensure they are arrays
        $this->sets = is_array($this->sets) ? explode(',', $this->sets[0]) : $this->sets;
        $this->reps = is_array($this->reps) ? explode(',', $this->reps[0]) : $this->reps;
        $this->weight = is_array($this->weight) ? explode(',', $this->weight[0]) : $this->weight;
        
        if (is_array($this->sets) && is_array($this->reps)) {
            foreach ($this->sets as $index => $set) {
                if (isset($this->reps[$index])) {
                    if(isset($this->weight[$index]))
                        $weight = (int)$this->weight[$index];
                    else
                        $weight = 1;
                    $setRep += (int)$set * (int)$this->reps[$index] * ($weight);
                }
            }
        }
        return [
            'id' => $this->id,
            'user_id' => $this->user_id,
            'set_reps' => $setRep,
            'created_at' => $this->created_at->format('Y-m-d H:i'),
            'updated_at' => $this->updated_at
        ];
    }
}
