<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'company_id',
        'group_id',
        'role_id',
        'usertype',
        'date',
        'action',
        'details',
        'address',
        'path',
        'old_data',
        'new_data',
        'filetype',
        'flag'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
