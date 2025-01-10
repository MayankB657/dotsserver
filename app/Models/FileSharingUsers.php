<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharingUsers extends Model
{
    use HasFactory;

    protected $table = 'file_sharing_users';
    public $primaryKey = 'id';
    public $timestamp = true;

    public function fileshare()
    {
        $this->belongsTo(FileSharing::class,'file_sharing_id');
    }
}
