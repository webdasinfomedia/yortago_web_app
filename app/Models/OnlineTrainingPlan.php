<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OnlineTrainingPlan extends Model
{
    use HasFactory;
    protected $guarded=[];
    public function attributes(): HasMany
    {
        return $this->hasMany(OnlineTrainingPlanAttribute::class, 'online_training_id', 'id');
    }
}
