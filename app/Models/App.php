<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    protected $fillable = ['name', 'icon','link','type','sort_order', 'status'];
}

?>