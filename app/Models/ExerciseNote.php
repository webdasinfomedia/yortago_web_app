<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseNote extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'new_item_id',
        'new_user_exercise_id',
        'notes',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exerciseItem()
    {
        return $this->belongsTo(NewExerciseWeekDayItem::class, 'new_item_id');
    }

    public function userExercise()
    {
        return $this->belongsTo(NewUserExercise::class, 'new_user_exercise_id');
    }
}
