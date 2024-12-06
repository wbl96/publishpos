<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id',
        'stock_quantity',
        'min_stock',
        'unit_cost',
        'notes'
    ];

    protected $casts = [
        'stock_quantity' => 'integer',
        'min_stock' => 'integer',
        'unit_cost' => 'decimal:2'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
