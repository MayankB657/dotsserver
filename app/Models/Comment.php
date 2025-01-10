<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;
    protected $fillable = [
        'file_id',
        'message',
        'sender',
        'receiver_id',
        'receiver_type',
        'group_id',
        'role_id',
        'parent',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'sender');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'receiver_id');
    }
    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }
    public function role()
    {
        return $this->belongsTo(Roles::class, 'role_id');
    }
    public function replies()
    {
        return $this->hasMany(Comment::class, 'parent'); 
    }

    public function commentRecivers()
    {
        return $this->hasMany(CommentReciver::class, 'comment_id');
    }
    
}
