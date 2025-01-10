<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;


    // Specify the fillable attributes for mass assignment
    protected $fillable = [
        'client_id', 'company_id', 'name', 'description', 'permissions',
    ];

    // Cast the permissions column as an array
    protected $casts = [
        'permissions' => 'array',
    ];

    /**
     * Relationship: A role belongs to a client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relationship: A role belongs to a company.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
