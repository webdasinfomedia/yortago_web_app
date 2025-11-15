<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InPersonPageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_small_heading',
        'slider_large_heading',
        'slider_short_description',
        'slider_image',
        'form_right_image',
        'form_image_youtube_url',
        'benefits_small_heading',
        'benefits_large_heading',
        'benefits_short_description',
        'benefits_1_heading',
        'benefits_1_large_heading',
        'benefits_1_short_description',
        'benefits_1_image',
        'benefits_2_heading',
        'benefits_2_large_heading',
        'benefits_2_short_description',
        'benefits_2_image',
        'benefits_3_heading',
        'benefits_3_large_heading',
        'benefits_3_short_description',
        'benefits_3_image',
    ];
}
