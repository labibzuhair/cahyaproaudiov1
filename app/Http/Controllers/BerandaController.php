<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\produk;
use App\Models\Rentals;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\Pemasukan;
use App\Models\Pengeluaran;
use Carbon\Carbon;
use App\Models\Transactions;
use Illuminate\Support\Facades\DB;


class BerandaController extends Controller
{
    public function index(Request $request)
    {
        // Get all distinct product types
        $data['types'] = Produk::select('type')->distinct()->get()->pluck('type');

        // Apply search and filter
        $query = Produk::query();

        $data['produks'] = $query->get();

        return view('layouts.main.beranda.beranda', $data);
    }

    public function beranda()
    {
        $user = Auth::user();
        $data['produks'] = Produk::all();
        $data['types'] = Produk::select('type')->distinct()->get()->pluck('type');
        $rentals = Rentals::with('produk', 'transaction.user')->get();
        $data['rentals'] = $rentals;

        // Ambil tanggal sekarang
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;

        // Hitung total pemasukan bulan ini
        $data['monthlyIncome'] = Pemasukan::whereMonth('date', $currentMonth)
            ->whereYear('date', $currentYear)
            ->sum('amount');

        // Hitung total pemasukan tahun ini
        $data['yearlyIncome'] = Pemasukan::whereYear('date', $currentYear)
            ->sum('amount');

        // Hitung total pengeluaran
        $data['totalExpenses'] = Pengeluaran::sum('amount');

        // Hitung saldo saat ini (Pendapatan - Pengeluaran)
        $data['currentBalance'] = $data['yearlyIncome'] - $data['totalExpenses'];

        // Hitung jumlah pesanan berdasarkan status
        $data['pendingOrders'] = Transactions::where('status', 'menunggu')->count();
        $data['approvedOrders'] = Transactions::where('status', 'disetujui')->count();
        $data['canceledOrders'] = Transactions::where('status', 'dibatalkan')->count();
        $data['completedOrders'] = Transactions::where('status', 'selesai')->count();

        // Ambil Data Pemasukan & Pengeluaran Per Bulan untuk Grafik
        $keuangan = DB::table('pemasukans')
            ->select(
                DB::raw("DATE_FORMAT(date, '%b') as bulan"),
                DB::raw("SUM(amount) as total_pemasukan")
            )
            ->groupBy('bulan')
            ->orderByRaw("FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')")
            ->get();

        $pengeluaran = DB::table('pengeluarans')
            ->select(
                DB::raw("DATE_FORMAT(date, '%b') as bulan"),
                DB::raw("SUM(amount) as total_pengeluaran")
            )
            ->groupBy('bulan')
            ->orderByRaw("FIELD(bulan, 'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec')")
            ->get();

        // Gabungkan data pemasukan dan pengeluaran
        $data['keuangan'] = collect($keuangan)->map(function ($item) use ($pengeluaran) {
            $pengeluaranItem = collect($pengeluaran)->firstWhere('bulan', $item->bulan);
            $item->total_pengeluaran = $pengeluaranItem->total_pengeluaran ?? 0;
            return $item;
        });

        if ($user) {
            $cartItems = CartItem::where('user_id', $user->id)->pluck('produk_id')->toArray();
            $data['cartItems'] = $cartItems;
            $data['getRecord'] = User::find($user->id);

            if ($user->is_role == 'admin') {
                return view('layouts.admin.beranda.beranda', $data);
            } elseif ($user->is_role == 'owner') {
                return view('layouts.owner.beranda.beranda', $data);
            } elseif ($user->is_role == 'customer') {
                return view('layouts.main.beranda.beranda', $data);
            }
        } else {
            return view('layouts.main.beranda.beranda', $data);
        }
    }



}
