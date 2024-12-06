<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'selling_price',
        'production_cost',
        'profit',
        'ingredients'
    ];

    protected $casts = [
        'ingredients' => 'array',
        'production_cost' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'profit' => 'decimal:2'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function inventory()
    {
        return $this->hasOne(Inventory::class);
    }
}