<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecycleBin extends Model
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
        'filetype',
        'extension',
        'tablename',
        'file_created_by',
        'file_created_at',
        'file_updated_at',
        
    ];

   
}


?>