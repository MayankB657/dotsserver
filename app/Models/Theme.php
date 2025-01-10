<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theme extends Model
{
    use HasFactory;
    protected $table = 'themes'; 
    protected $fillable = [
        'name',
        'image',
        'dark_color',
        'medium_color',
        'light_color',
        'color_light_grey',
        'sidebar_bg_image'
    ];

}
