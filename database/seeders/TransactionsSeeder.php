<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\District;
use App\Models\Transactions;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $user = User::first();
        $district = District::first();
        Transactions::create([
            'user_id' => $user->id,
            'district_id' => $district->id,
            'order_name' => 'John Doe',
            'order_whatsapp' => '08123456789',
            'installation_address' => 'Jl. Contoh No. 123',
            'total_amount' => 500000,
            'status' => 'menunggu',
        ]);
    }
}
