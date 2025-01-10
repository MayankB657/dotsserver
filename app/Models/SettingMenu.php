<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SettingMenu extends Model
{
    protected $table = 'setting_menu'; // Explicitly define the table name

    protected $fillable = [
        'parent', 'name', 'route', 'hassubmenu', 'status'
    ];
}
