<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'code',
        'user_id',
        'amount_before_discount',
        'amount_after_discount',
        'total_amount',
        'discount_amount',
        'status',
        'remarks'
    ];
}
