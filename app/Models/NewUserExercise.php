<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewUserExercise extends Model
{
    use HasFactory;

    public function newExercise()
    {
        return $this->belongsTo(NewExercise::class, 'new_exercise_id');
    }

    // If you want an alias that's just "exercise()", do it this way:
    public function exercise()
    {
        return $this->belongsTo(NewExercise::class, 'new_exercise_id');
    }

    // Relationship to logs
    public function logs()
    {
        return $this->hasMany(NewUserExerciseLog::class, 'new_user_exercise_id');
    }

}
