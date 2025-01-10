<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'client_id', 'name', 'email', 'contact', 'logo',
    ];

    /**
     * Relationship: A company belongs to a client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relationship: A company can have many groups.
     */
    public function groups()
    {
        return $this->hasMany(Group::class);
    }

    public function companyHead()
    {
        return $this->belongsTo(User::class, 'company_head', 'id');
    }
}
