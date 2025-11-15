<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExerciseList extends Model
{
    use HasFactory;
    protected $fillable = ['weight','weight_value']; 

    public function body_part()
    {
        return $this->belongsTo(BodyPart::class,'body_part_id');
    }

    public function exercise_style()
    {
        return $this->belongsTo(ExerciseStyle::class);
    }

    public function favouriteExercise(){
        return $this->hasMany(Favourite::class,'exercise_id');
    }

    public function userLogs()
    {
        return $this->hasMany(UserLog::class, 'new_exercise_list_id');
    }
    public function exerciseDayItem(){
        return $this->belongsTo(NewExerciseWeekDayItem::class);
    } 

    public function exerciseDayItems(){
        return $this->hasMany(NewExerciseWeekDayItem::class, 'exercise_list_id');
    } 
    
    /**Alternate exercise list relationship */

    public function alternateExercises()
    {
        return $this->hasMany(AlternateExerciseList::class, 'exercise_list_id');
    }
}
