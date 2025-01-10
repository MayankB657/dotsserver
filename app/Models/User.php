<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;  // Use this as the base class
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable  // Ensure the model extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'client_id', 'company_id', 'group_id', 'role_id', 'usertype', 'name', 'username', 'email', 'password', 'sizeMax', 'ip_address',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'permissions' => 'array',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
?>