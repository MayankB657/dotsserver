<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContextOption extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function contextType()
    {
        return $this->belongsTo(ContextType::class, 'contexttype');
    }
}
?>