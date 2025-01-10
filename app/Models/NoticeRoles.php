<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeRoles extends Model
{
    use HasFactory;

    protected $table = 'notice_roles';
    public $primaryKey = 'id';
    public $timestamp = true;
}
