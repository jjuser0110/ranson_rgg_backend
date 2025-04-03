<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;


    protected $fillable = [
        'transaction_no',
        'datetime',
        'user_id',
        'product_variant_id',
        'cost',
        'qty',
        'amount',
        'payment',
        'status',
        'bank_receipt',
        'player_id'
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function product_variant()
    {
        return $this->belongsTo('App\Models\ProductVariant');
    }

    public function getInvNoAttribute()
    {
        $transaction_no = str_pad($this->transaction_no, 5, '0', STR_PAD_LEFT);
        $invoice_number = "INV2025" . $transaction_no;
        return $invoice_number;
    }
}
