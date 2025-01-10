<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightApp extends Model
{
    protected $fillable = [
        'group', 'name', 'link', 'description', 'icon', 'open_type', 'width',
        'height', 'sort_order', 'status', 'add_app'
    ];

    public function category()
    {
        return $this->belongsTo(LightAppCategory::class, 'group');
    }
}

?>