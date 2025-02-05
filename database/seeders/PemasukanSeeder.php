<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PemasukanSeeder extends Seeder
{
    public function run()
    {
        // Ambil ID transaksi yang telah ada
        $transactionIds = DB::table('transactions')->pluck('id')->toArray();

        for ($i = 0; $i < 120; $i++) {
            DB::table('pemasukans')->insert([
                'transaction_id' => $transactionIds[array_rand($transactionIds)], // Menggunakan transaksi acak
                'amount' => rand(500000, 5000000), // Rp 500.000 - Rp 5.000.000
                'description' => 'Pemasukan dari transaksi ke-' . rand(1, 50),
                'date' => Carbon::now()->subDays(rand(1, 365)), // 1 tahun ke belakang
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
