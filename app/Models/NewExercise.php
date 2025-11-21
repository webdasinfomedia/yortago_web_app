<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class NewExercise extends Model
{
    use HasFactory;
    protected $table = 'new_exercises';
    protected $primaryKey = 'id';
    protected $fillable = [
        'title',
        'category_id',
        'image',
        'youtube_link',
        'type',
    ]; 

    public function age(): BelongsTo
    {
        return $this->belongsTo(Age::class, 'age_id', 'id');
    }
    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class, 'gender_id', 'id');
    }
    public function experience_level(): BelongsTo
    {
        return $this->belongsTo(ExperienceLevel::class, 'experience_level_id', 'id');
    }
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class, 'equipment_id', 'id');
    }
    public function weeks()
    {
        return $this->hasMany(NewExerciseWeek::class);
    }

    public function exerciseWeeks()
    {
        return $this->hasMany(NewExerciseWeek::class,'new_exercise_id');
    }

    public function users()
    {
        return $this->belongsToMany(User::class,'new_user_exercises')
            ->withPivot('start_date', 'completion_date','id','deleted_at')
            ->withTimestamps()->wherePivotNull('deleted_at');
    }

    //category
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function favouriteExercise(){
        return $this->hasMany(Favourite::class,'exercise_id');
    }


    public function log()
    {
        return $this->hasMany(NewUserExerciseLog::class,'new_user_exercise_id');
    }

    // public function exerciseWeeks()
    // {
    //     return $this->hasMany(NewExerciseWeek::class, 'new_exercise_id');
    // }
public function exercise()
{
    return $this->belongsTo(NewExercise::class, 'new_exercise_id');
}
}
