<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class ProductVariant extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'name',
        'short_name',
        'sku',
        'price',
        'discount',
        'tag',
        'description',
        'quantity',
        'status',
        'remarks',
    ];

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
