<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProdukSeeder;
use Database\Seeders\TransactionsSeeder;
use Database\Seeders\RentalsSeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(ProdukSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DistrictSeeder::class);
        // $this->call(TransactionsSeeder::class);
        // $this->call(RentalsSeeder::class);
        // $this->call([
        //     PemasukanSeeder::class,
        //     PengeluaranSeeder::class,
        //     LaporanKeuanganSeeder::class,
        // ]);

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);
    }
}
