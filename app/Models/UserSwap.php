<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSwap extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'exercise_item_id', 'new_item_id','new_user_exercise_id'];

}
