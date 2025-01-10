<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk;

class CartItem extends Model
{
    /** @use HasFactory<\Database\Factories\CartItemFactory> */
    use HasFactory;
    protected $fillable = [
        'user_id',
        'produk_id',
        'quantity'
    ];
    public function produk()
    {
        return $this->belongsTo(Produk::class, 'produk_id');
    }
}
