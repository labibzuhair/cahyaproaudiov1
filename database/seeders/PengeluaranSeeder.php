<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengeluaranSeeder extends Seeder
{
    public function run()
    {
        $categories = ['Operasional', 'Gaji', 'Pajak', 'Listrik', 'Sewa', 'Lainnya'];

        for ($i = 0; $i < 120; $i++) {
            DB::table('pengeluarans')->insert([
                'category' => $categories[array_rand($categories)],
                'amount' => rand(300000, 4000000), // Rp 300.000 - Rp 4.000.000
                'description' => 'Pengeluaran untuk ' . $categories[array_rand($categories)],
                'date' => Carbon::now()->subDays(rand(1, 365)), // 1 tahun ke belakang
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
