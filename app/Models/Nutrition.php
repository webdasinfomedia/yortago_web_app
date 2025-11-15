<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Nutrition extends Model
{
    use HasFactory;

    protected $guarded=[];

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
     * Get all of the comments for the Nutrition
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function nutrition_weeks(): HasMany
    {
        return $this->hasMany(NutritionWeek::class, 'nutrition_id', 'id');
    }
}
