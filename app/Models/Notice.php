<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notice extends Model
{
    use HasFactory;

    protected $table = 'notice';
    public $primaryKey = 'id';
    public $timestamp = true;

    public function users()
    {
        return $this->hasMany(NoticeUsers::class);
    }

    public function groups()
    {
        return $this->hasMany(NoticeGroups::class);
    }

    public function roles()
    {
        return $this->hasMany(NoticeRoles::class);
    }
}
