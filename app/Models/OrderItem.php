<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'order_id',
        'product_id',
        'product_name',
        'variant_id',
        'variant_name',
        'quantity',
        'amount',
        'discount',
        'image'
    ];
}
