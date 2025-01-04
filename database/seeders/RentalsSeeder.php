<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rentals;


class RentalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Rentals::create([ 
            'transactions_id' => 1, 
            'produk_id' => 1, 
            'rental_date' => '2023-01-01', 
            'return_date' => '2023-01-02', 
            'location' => 'Jakarta', 
            'price' => 2000000, 
            'quantity' => 1 
        ]); 
        Rentals::create([ 
            'transactions_id' => 2, 
            'produk_id' => 2, 
            'rental_date' => '2023-01-05', 
            'return_date' => '2023-01-06', 
            'location' => 'Bandung', 
            'price' => 5000000, 
            'quantity' => 1 
        ]);
    }
}
