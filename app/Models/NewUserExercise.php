<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NewUserExercise extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'new_user_exercises';

    protected $fillable = [
        'user_id',
        'new_exercise_id',
        'start_date',
        'completion_date',
    ];

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

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
