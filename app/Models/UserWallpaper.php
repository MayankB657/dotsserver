<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserWallpaper extends Model
{
    use HasFactory;

    protected $table = 'user_wallpaper';

    protected $fillable = [
        'user_id',
        'dashboard_display',
        'login_display',
        'theme_id'
    ];
}

