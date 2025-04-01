<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    
    protected $fillable = [
        'name',
        'short_name',
        'description',
        'short_description',
        'guide',
        'others',
        'tags',
        'sku',
        'image',
        'status'
    ];
}
