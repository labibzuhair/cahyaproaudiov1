<?php

namespace Database\Seeders;

use App\Models\Rentals;
use App\Models\Transactions;
use App\Models\produk;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;






class RentalsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */

    public function run()
    {
        // Anggap ada 100 rental untuk dipakai pada tabel pemasukan
        for ($i = 0; $i < 100; $i++) {
            DB::table('rentals')->insert([
                'transactions_id' => rand(1, 50), // ID acak untuk transaksi yang sudah ada
                'produk_id' => rand(1, 3), // ID acak untuk produk, asumsikan ada 10 produk
                'rental_date' => Carbon::now()->subDays(rand(1, 365)),
                'return_date' => Carbon::now()->addDays(rand(1, 30)),
                'rental_days' => rand(1, 14),
                'location' => 'Lokasi ' . rand(1, 100),
                'delivery_fee' => rand(50000, 500000),
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }


}
