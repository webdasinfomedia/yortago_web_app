<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BodyPart extends Model
{
    use HasFactory;



    public function exerciseLists()
    {
        return $this->hasMany(ExerciseList::class, 'body_part_id');
    }
    public function userLogs()
    {
        return $this->hasMany(NewUserExerciseLog::class);
    }

}
