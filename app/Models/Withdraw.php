<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Withdraw extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'date',
        'reference_no',
        'user_id',
        'bank',
        'bank_acc',
        'amount',
        'status',
        'receipt'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getRefNoAttribute()
    {
        $reference_no = str_pad($this->reference_no, 5, '0', STR_PAD_LEFT);
        $reference_number = "W2025" . $reference_no;
        return $reference_number;
    }
}
