<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */




    public function run()
    {
        // Anggap ada 50 transaksi untuk dipakai pada tabel pemasukan
        for ($i = 0; $i < 50; $i++) {
            DB::table('transactions')->insert([
                'user_id' => rand(1, 3), // ID acak untuk pengguna, asumsikan ada 10 pengguna
                'district_id' => rand(1, 2), // ID acak untuk distrik, asumsikan ada 5 distrik
                'order_name' => 'Order ' . rand(1, 100),
                'order_whatsapp' => '08' . rand(100000000, 999999999),
                'installation_address' => 'Alamat ' . rand(1, 100),
                'total_amount' => rand(100000, 5000000),
                'status' => ['menunggu', 'disetujui', 'diproses', 'selesai', 'dibatalkan'][array_rand(['menunggu', 'disetujui', 'diproses', 'selesai', 'dibatalkan'])],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now(),
            ]);
        }
    }



}
