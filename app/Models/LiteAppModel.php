<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiteAppModel extends Model
{
    use HasFactory;

         protected $table = 'light_app';

    protected $fillable = [
        'name',
        'website_link',
        'app_group',
        'app_description',
        'picture_icon',
        'open_type',
        'dialog_width',
        'dialog_height',
        'allow_width_adjustment',
        'minimilist_title_bar',
    ];

}
