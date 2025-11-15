<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserExerciseProgramWeek extends Model
{
    use HasFactory;

    protected $guarded=[];


    public function exercise_days(): HasMany
    {
        return $this->hasMany(UserExerciseProgramDay::class, 'user_exercise_program_week_id', 'id');
    }
}
