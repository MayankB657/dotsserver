<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;



class LoginLog extends Model 
{
    use HasFactory;

     
     
    protected $fillable = [
        'user_id',
        'user_image',
        'login_time',
        'system_version',
        'system',
        'system_image',
        'browser',
        'browser_image',
        'login_address',
    
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
