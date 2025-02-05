<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class LaporanKeuanganSeeder extends Seeder
{
    public function run()
    {
        $currentYear = Carbon::now()->year;

        for ($month = 1; $month <= 12; $month++) {
            $total_income = DB::table('pemasukans')
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $month)
                ->sum('amount');

            $total_expense = DB::table('pengeluarans')
                ->whereYear('date', $currentYear)
                ->whereMonth('date', $month)
                ->sum('amount');

            DB::table('laporan_keuangans')->insert([
                'month' => $month,
                'year' => $currentYear,
                'total_income' => $total_income,
                'total_expense' => $total_expense,
                'net_profit' => $total_income - $total_expense,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
