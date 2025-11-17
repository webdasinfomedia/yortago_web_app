<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class UserExerciseProgramDay extends Model
{
    use HasFactory;

    protected $guarded=[];

    public function exercise_infos(): HasMany
    {
        return $this->hasMany(UserExerciseProgram::class, 'exercise_program_day_id', 'id');
    }
}
