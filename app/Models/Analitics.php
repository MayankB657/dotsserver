<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Analitics extends Model
{
    protected $table = 'analitics'; // Explicitly define the table name

    protected $fillable = [
        'parent', 'name', 'graph_type', 'hassubmenu', 'status'
    ];
}