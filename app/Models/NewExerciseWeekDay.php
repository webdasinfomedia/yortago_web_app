<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NewExerciseWeekDay extends Model
{
    use HasFactory;

    protected $fillable = [
        'new_exercise_week_id',
        'title',
        'summary',
        'duration',
        'day_number',
    ];

    public function week()
    {
        return $this->belongsTo(NewExerciseWeek::class);
    }
    public function exerciseWeek()
    {
        return $this->belongsTo(NewExerciseWeek::class,'new_exercise_week_id');
    }

    public function exerciseItems()
    {
        return $this->hasMany(NewExerciseWeekDayItem::class);
    }

    public function exerciseItem()
    {
        return $this->hasMany(NewExerciseWeekDayItem::class,'new_exercise_week_day_id');
    }

}
