<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Folder extends Model
{
    use HasFactory;

    protected $fillable = [
        'folder',
        'name',
        'path',
        'parentpath',
        'openwith',
        'sort_order',
        'status',
        'is_root',
        'created_by'
    ];

    public function parent()
    {
        return $this->belongsTo(Folder::class, 'folder');
    }

    public function children()
    {
        return $this->hasMany(Folder::class, 'folder');
    }

    public function files()
    {
        return $this->hasMany(File::class, 'folder');
    }
}


?>