<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favourite extends Model
{
    use HasFactory;

    protected $table = 'favourite_exercises';

    protected $fillable = [
        "user_id",
        "exercise_id"
    ];
    
}
