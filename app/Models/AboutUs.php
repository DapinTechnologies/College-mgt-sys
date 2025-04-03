<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    // Specify the table name since Laravel would look for "about_uses" by default
    protected $table = 'about_us';

    // Optionally, allow mass assignment on these fields
    protected $fillable = [
        'language_id',
        'label',
        'title',
        'short_desc',
        'description',
        'features',
        'attach',
        'video_id',
        'button_text',
        'mission_title',
        'mission_desc',
        'mission_icon',
        'mission_image',
        'vision_title',
        'vision_desc',
        'vision_icon',
        'vision_image',
        'status'
    ];
}
