<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewUserExerciseLog extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'new_item_id', 'replaced_item_id', 'sets', 'reps', 'weight', 'notes','new_user_exercise_id','intensity','time_taken', 'weight_unit',
                            'body_part_id','status', 'alternate','alternate_exercise_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function exerciseItem()
    {
        return $this->belongsTo(NewExerciseWeekDayItem::class, 'new_item_id');
    }

    public function replacedExerciseItem()
    {
        return $this->belongsTo(NewExerciseWeekDayItem::class, 'replaced_item_id');
    }

    public function weeks(){
        return $this->hasMany(NewExerciseWeek::class);
    }

    public function newExercise()
    {
        return $this->belongsTo(NewExercise::class, 'new_user_exercise_id'); // Assuming foreign key is `new_exercise_id`
    }

    public function newUserExercise(){
        return $this->belongsTo(NewUserExercise::class, 'new_user_exercise_id')->withTrashed();
    }
    // public function exercise()
    // {
    //     return $this->belongsTo(NewUserExercise::class, 'new_user_exercise_id');
    // }
    
    public function userExerciseProgram()
    {
        return $this->belongsTo(NewUserExercise::class, 'new_user_exercise_id')->withTrashed();
    }

    // Relationship to the actual exercise (through userExerciseProgram)
    public function exercise()
    {
        return $this->hasOneThrough(
            NewExercise::class,
            NewUserExercise::class,
            'id', // Foreign key on NewUserExercise table
            'id', // Foreign key on NewExercise table
            'new_user_exercise_id', // Local key on NewUserExerciseLog table
            'new_exercise_id' // Local key on NewUserExercise table
        )->select(
            'new_exercises.*',
            'new_user_exercises.id as user_exercise_id'
        );
    }

    // Relationship to body part
    public function bodyPart()
    {
        return $this->belongsTo(BodyPart::class, 'body_part_id');
    }

     /**
     * ✅ Relationship to the alternate exercise (if this log is for an alternate exercise)
     */
    public function alternateExercise()
    {
        return $this->belongsTo(AlternateExerciseList::class, 'alternate_exercise_id');
    }
}
