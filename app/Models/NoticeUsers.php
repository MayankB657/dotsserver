<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeUsers extends Model
{
    use HasFactory;

    protected $table = 'notice_users';
    public $primaryKey = 'id';
    public $timestamp = true;
}
