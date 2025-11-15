<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlternateExerciseList extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'exercise_list_id',
        'new_exercise_week_day_item_id',
        'name',
        'body_part_id',
        'exercise_style_id',
        'image',
        'sets',
        'reps',
        'weight',
        'weight_value',
        'rest',
        'tempo',
        'intensity',
        'video_link',
        'notes'
    ];

    public function exerciseList()
    {
        return $this->belongsTo(ExerciseList::class, 'exercise_list_id');
    }

    public function body_part()
    {
        return $this->belongsTo(BodyPart::class, 'body_part_id');
    }

    public function exercise_style()
    {
        return $this->belongsTo(ExerciseStyle::class);
    }
      public function newExerciseItem()
    {
        return $this->belongsTo(NewExerciseWeekDayItem::class, 'new_exercise_week_day_item_id');
    }
}