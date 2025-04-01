<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class UserVerification extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'email',
        'code',
        'verified',
        'email_verified_at',
    ];
}
