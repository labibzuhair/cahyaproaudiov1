<?php

namespace App\Http\Controllers;

use App\Models\Income;
use App\Models\Expense;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Models\FinancialReport;
use App\Models\LaporanKeuangan;
use App\Http\Controllers\Controller;

class LaporanKeuanganController extends Controller
{
    // Menampilkan halaman keuangan
    public function index()
    {
        $incomes = Pemasukan::all();
        $expenses = Pengeluaran::all();
        $financialReports = LaporanKeuangan::orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        return view('admin.finance.index', compact('incomes', 'expenses', 'financialReports'));
    }

    // Tambah pengeluaran baru
    public function storeExpense(Request $request)
    {
        $request->validate([
            'category' => 'required|string',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'description' => 'nullable|string'
        ]);

        Pengeluaran::create($request->all());

        return redirect()->back()->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    // Generate laporan keuangan
    public function generateReport()
    {
        $month = now()->month;
        $year = now()->year;

        $totalIncome = Pemasukan::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');
        $totalExpense = Pengeluaran::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');

        LaporanKeuangan::updateOrCreate(
            ['month' => $month, 'year' => $year],
            [
                'total_income' => $totalIncome,
                'total_expense' => $totalExpense,
                'net_profit' => $totalIncome - $totalExpense,
            ]
        );

        return redirect()->back()->with('success', 'Laporan keuangan berhasil diperbarui.');
    }
}
