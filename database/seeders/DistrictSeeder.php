<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        District::create(['name' => 'Kebumen', 'delivery_fee' => 200000,]);
        District::create(['name' => 'Ambal', 'delivery_fee' => 300000,]);
    }
}
