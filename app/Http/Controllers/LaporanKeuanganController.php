<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use App\Models\LaporanKeuangan;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LaporanKeuanganController extends Controller
{
    // Menampilkan halaman utama keuangan
    public function index()
    {
        $user = Auth::user();
        $getRecord = User::find($user->id);

        // Ambil total pemasukan dari tabel Pemasukan
        $incomeTotal = Pemasukan::sum('amount');

        // Ambil total pengeluaran dari tabel Pengeluaran
        $expenseTotal = Pengeluaran::sum('amount');

        // Ambil laporan keuangan bulanan
        $financialReports = LaporanKeuangan::orderBy('year', 'desc')->orderBy('month', 'desc')->get();

        return view('layouts.admin.keuangan.index', compact('getRecord', 'incomeTotal', 'expenseTotal', 'financialReports'));
    }

    public function pemasukanHistory()
    {
        $user = Auth::user();
        $getRecord = User::find($user->id);
        $incomes = Pemasukan::orderBy('date', 'desc')->get();
        return view('layouts.admin.keuangan.pemasukan', compact('incomes', 'getRecord'));
    }



    // Menampilkan pemasukan berdasarkan transaksi yang telah selesai
    public function showIncome()
    {
        $user = Auth::user();
        $getRecord = User::find($user->id);

        // Ambil pemasukan dari transaksi yang memiliki status "selesai"
        $incomeTotal = Transactions::where('status', 'selesai')->sum('total_amount');
        $incomes = Transactions::where('status', 'selesai')->orderBy('created_at', 'desc')->get();

        return view('layouts.admin.keuangan.pemasukan', compact('getRecord', 'incomeTotal', 'incomes'));
    }

    // Menampilkan halaman pengeluaran
    public function pengeluaranHistory()
    {
        $user = Auth::user();
        $getRecord = User::find($user->id);
        $expenses = Pengeluaran::orderBy('date', 'desc')->get();
        return view('layouts.admin.keuangan.pengeluaran', compact('expenses', 'getRecord'));
    }

    public function createPengeluaran()
    {
        $user = Auth::user();
        $getRecord = User::find($user->id);
        return view('layouts.admin.keuangan.pengeluaran_create', compact('getRecord'));
    }
    // Tambah pengeluaran baru
    public function storePengeluaran(Request $request)
    {
        $request->validate([
            'category' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'description' => 'nullable|string',
            'date' => 'required|date',
        ]);

        Pengeluaran::create([
            'category' => $request->category,
            'amount' => $request->amount,
            'description' => $request->description,
            'date' => $request->date,
        ]);

        return redirect()->route('admin.keuangan.pengeluaran')->with('success', 'Pengeluaran berhasil ditambahkan.');
    }

    // Generate laporan keuangan
    public function generateReport()
    {
        $month = now()->month;
        $year = now()->year;

        // Pemasukan dari transaksi yang memiliki status "selesai"
        $totalIncome = Transactions::where('status', 'selesai')->whereMonth('created_at', $month)->whereYear('created_at', $year)->sum('total_amount');

        // Total pengeluaran
        $totalExpense = Pengeluaran::whereMonth('date', $month)->whereYear('date', $year)->sum('amount');

        // Simpan atau update laporan keuangan
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
    public function destroyPengeluaran($id)
    {
        $expense = Pengeluaran::find($id);

        if (!$expense) {
            return redirect()->back()->with('error', 'Pengeluaran tidak ditemukan.');
        }

        $expense->delete();

        return redirect()->back()->with('success', 'Pengeluaran berhasil dihapus.');
    }

}
