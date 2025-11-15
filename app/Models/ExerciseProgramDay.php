<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ExerciseProgramDay extends Model
{
    use HasFactory;
    protected $guarded=[];
    protected $hidden=['id'];


    public function exercise_infos(): HasMany
    {
        return $this->hasMany(ExerciseProgramInfo::class, 'exercise_program_day_id', 'id');
    }
}
