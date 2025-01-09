<?php

namespace Database\Seeders;

use App\Models\Rentals;
use App\Models\Transactions;
use App\Models\produk;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class RentalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $transaction = Transactions::first();
        $produk = Produk::first();
        $rental_date = Carbon::now();
        $rental_days = 3;
        $return_date = $rental_date->copy()->addDays($rental_days - 1);
        Rentals::create([
            'transactions_id' => $transaction->id,
            'produk_id' => $produk->id,
            'rental_date' => $rental_date,
            'return_date' => $return_date,
            'rental_days' => $rental_days,
            'location' => 'Jl. Contoh No. 123',
            'delivery_fee' => 200000,
        ]);
    }
}
