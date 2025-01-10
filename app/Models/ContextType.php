<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContextType extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function contextOptions()
    {
        return $this->hasMany(ContextOption::class, 'contexttype');
    }
}
?>