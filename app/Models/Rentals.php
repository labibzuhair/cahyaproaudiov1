<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\produk;
use App\Models\Transactions;

class Rentals extends Model
{
    /** @use HasFactory<\Database\Factories\RentalsFactory> */
    use HasFactory;
    protected $fillable = ['transactions_id', 'produk_id', 'rental_date', 'return_date', 'location', 'price', 'quantity'];

    public function transaction()
    {
        return $this->belongsTo(Transactions::class, 'transactions_id');
    }

    public function produk()
    {
        return $this->belongsTo(Produk::class);
    }

}
