<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlinePageSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'top_section_small_heading',
        'top_section_large_heading',
        'left_card_heading',
        'left_card_description',
        'left_card_image',
        'right_card_heading',
        'right_card_description',
        'right_card_image',
        'middle_section_small_heading',
        'middle_section_large_heading',
        'middle_section_description',
        'middle_section_left_big_image',
        'middle_section_left_small_image',
        'middle_section_left_youtube_url',
        'middle_section_right_big_image',
        'middle_section_right_small_image',
        'middle_section_right_youtube_url',
    ];


}
