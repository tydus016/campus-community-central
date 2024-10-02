<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderedProducts extends Model
{
    protected $table = 'ordered_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'size_id',
        'variant_id',
        'quantity',
        'price',
        'total',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'price' => 'float',
        'total' => 'float',
    ];
}
