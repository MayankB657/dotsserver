<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommentReciver extends Model
{
   use HasFactory;
    protected $fillable = [
        'receiver_id',
        'comment_id',
    ];

     public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }
}
