<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewExerciseWeek extends Model
{
    use HasFactory;
    protected $fillable = [
        'new_exercise_id','week_number',
    ];
    public function exercise()
    {
        return $this->belongsTo(NewExerciseWeek::class);
    }

    public function days()
    {
        return $this->hasMany(NewExerciseWeekDay::class);
    }

    public function exercisedays()
    {
        return $this->hasMany(NewExerciseWeekDay::class, 'new_exercise_week_id');
    }

    public function newExercise()
    {
        return $this->belongsTo(NewExercise::class, 'new_exercise_id');
    }


}
