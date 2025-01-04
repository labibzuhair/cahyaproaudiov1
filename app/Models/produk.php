<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class produk extends Model
{
    /** @use HasFactory<\Database\Factories\ProdukFactory> */
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
        'price',
        'type',
        'stock',
        'photo_main',
        'photo_1',
        'photo_2',
        'photo_3',
        'photo_4',
    ];
}
