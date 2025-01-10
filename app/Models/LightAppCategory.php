<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LightAppCategory extends Model
{
    protected $fillable = ['name', 'sort_order', 'status'];

    public function lightApps()
    {
        return $this->hasMany(LightApp::class, 'group');
    }
}
?>