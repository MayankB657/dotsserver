<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PermissionList extends Model
{
    use HasFactory;

    protected $table = 'permission_list';  // Explicitly specify the table name

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'name', 
        'permission_group_name', 
        'permission_group_flag', 
        'permission_route', 
        'permission_keyword', 
        'sort_order', 
        'status',
    ];

    // Optionally, you can add relationships or additional logic here as needed
}
