<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewExerciseWeekDayItem extends Model
{
    use HasFactory;

    //fillable
    public $fillable = ['exercise_list_id','new_exercise_week_day_id','item_id', 'sets', 'reps', 'rest', 'tempo', 'intensity', 'weight','weight_value', 'video_link', 'notes', 'name','image'];

    public function day()
    {
        return $this->belongsTo(NewExerciseWeekDay::class);
    }

    public function exercisedays()
    {
        return $this->belongsTo(NewExerciseWeekDay::class, 'new_exercise_week_day_id');
    }

    public function exercise_list(){
        return $this->belongsTo(ExerciseList::class,'exercise_list_id');
    }

    public function userExerciseLogs(){
        return $this->hasMany(NewUserExerciseLog::class, 'new_item_id');
    }

     public function alternateExercises()
    {
        return $this->hasMany(AlternateExerciseList::class, 'new_exercise_week_day_item_id');
    }

}
