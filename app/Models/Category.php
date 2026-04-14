<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = ['name', 'division'];
    
    // Relasi: Sebuah Category memiliki banyak Item
    public function items()
    {
        return $this->hasMany(Item::class);
    }
}
