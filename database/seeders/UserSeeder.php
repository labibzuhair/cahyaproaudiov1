<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Admin User',
                'email' => 'admin@example.com',
                'password' => Hash::make('password'),
                'is_role' => 'admin',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Owner User',
                'email' => 'owner@example.com',
                'password' => Hash::make('password'),
                'is_role' => 'owner',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Customer User',
                'email' => 'customer@example.com',
                'password' => Hash::make('password'),
                'is_role' => 'customer',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
