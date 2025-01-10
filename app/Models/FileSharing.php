<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileSharing extends Model
{
    use HasFactory;

    protected $table = 'file_sharing';
    public $primaryKey = 'id';
    public $timestamp = true;

    public function folder()
    {
        return $this->belongsTo(File::class,'folders_id');
    }

    public function file()
    {
        return $this->belongsTo(File::class,'files_id');
    }

        public function sharedByUser()
    {
        return $this->belongsTo(User::class, 'sharedby_users_id');
    }
}
