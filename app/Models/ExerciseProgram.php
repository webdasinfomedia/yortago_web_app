<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExerciseProgram extends Model
{
    use HasFactory,SoftDeletes;

    protected $guarded=[];


    /**
     * Get the user that owns the ExerciseProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
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

    /**
     * Get all of the comments for the ExerciseProgram
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function exercise_info(): HasMany
    {
        return $this->hasMany(ExerciseProgramInfo::class, 'exercise_program_id', 'id')->orderBy('order_no','asc');
    }
    public function exercise_weeks(): HasMany
    {
        return $this->hasMany(ExerciseProgramWeek::class, 'exercise_program_id', 'id')->orderBy('created_at','asc');
    }
}
