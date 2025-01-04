<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Transactions;

class TransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run() { 
        Transactions::create([ 
            'user_id' => 1, 
            'order_name' => 
            'John Doe', 
            'order_whatsapp' => '08123456789', 
            'installation_address' => 'Jl. Merdeka No. 1, Jakarta', 
            'total_amount' => 2000000, 'status' => 'completed' 
        ]); 
        Transactions::create([ 
            'user_id' => 2, 
            'order_name' => 'Jane Smith', 
            'order_whatsapp' => '08234567890', 
            'installation_address' => 'Jl. Kemerdekaan No. 2, Bandung', 
            'total_amount' => 5000000, 
            'status' => 'completed' 
        ]);
     }
}
