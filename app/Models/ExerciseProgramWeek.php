<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciseProgramWeek extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden = ['id'];

    public function exercise_days(): HasMany
    {
        return $this->hasMany(ExerciseProgramDay::class, 'exercise_program_week_id', 'id');
    }
}
