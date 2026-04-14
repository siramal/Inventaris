<?php

namespace App\Models;

use App\Models\Lending;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Item extends Model
{
    use HasFactory;

    protected $fillable = ['category_id', 'name', 'total', 'repair'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function lendings(): HasMany
    {
        return $this->hasMany(Lending::class);
    }
}
