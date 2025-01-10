<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'name', 'email', 'contact', 'logo',
    ];

    /**
     * Relationship: A client can have many groups.
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    /**
     * Relationship: A client can have many companies.
     */
    public function companies()
    {
        return $this->hasMany(Company::class);
    }

    public function clientHead()
    {
        return $this->belongsTo(User::class, 'client_head');
    }

}
