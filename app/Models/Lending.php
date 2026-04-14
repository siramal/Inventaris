<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lending extends Model
{
    protected $fillable = [
        'item_id',
        'total',
        'name',
        'notes',
        'date',
        'returned_at',
        'user_id',
        'signature',
    ];

    protected $casts = [
        'date' => 'datetime',
        'returned_at' => 'datetime',
    ];

    // Relasi ke tabel Item
    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    // Relasi ke tabel User (Operator)
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
