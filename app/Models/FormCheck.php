<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FormCheck extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id', 'file', 'reply',
    ];

    // Add this relationship
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
