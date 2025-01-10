<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GraphData extends Model
{
    use HasFactory;

    protected $table = 'graph_datas';  
    // protected $guarded = [];
    protected $fillable = [
        'user_id',
        'activitygroup_id',
        'activitytype_id',
        'graphtype',
        'datetype',
        'startdate',
        'enddate',        
        'flag',
        'default'
    ];
    
}
