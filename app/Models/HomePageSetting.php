<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomePageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'slider_small_heading',
        'slider_large_heading',
        'slider_short_description',
        'slider_image',
        'page_heading_small',
        'page_heading_large',
        'page_heading_short_description',
        'section_1_heading',
        'section_1_text',
        'section_1_image',
        'section_1_youtube_url',
        'section_2_heading',
        'section_2_text',
        'section_2_image',
        'section_2_left_image',
        'section_2_youtube_url',
    ];
}
