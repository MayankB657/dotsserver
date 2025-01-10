<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserType extends Model
{
    use HasFactory;

    protected $table = 'user_type';  // Explicitly specify the table name

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'name', 
        'flag', 
        'related_table', 
        'level', 
        'voice_authentication', 
        'face_authentication',
    ];

    // Optionally define any relationships if necessary based on the related_table
    // For example, if related_table refers to a relationship with the 'users' table,
    // you can define relationships dynamically based on the related_table attribute.
}
