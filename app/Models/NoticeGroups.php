<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NoticeGroups extends Model
{
    use HasFactory;

    protected $table = 'notice_groups';
    public $primaryKey = 'id';
    public $timestamp = true;
}
