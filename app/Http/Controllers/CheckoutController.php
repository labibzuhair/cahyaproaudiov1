<?php

namespace App\Http\Controllers;

use Exception;
use Carbon\Carbon;
use App\Models\User;
use App\Models\produk;
use App\Models\Rentals;
use App\Models\CartItem;
use App\Models\District;
use App\Models\Transactions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewTransactionNotification;


class CheckoutController extends Controller
{
    // Fungsi untuk mendapatkan data transaksi dan mengembalikannya sebagai JSON
    public function fetchTransactionsCustomer()
    {
        // Mengambil data transaksi yang memiliki status tertentu
        $transactions = Transactions::with(['rentals.produk', 'district'])
            ->whereIn('status', ['disetujui', 'diproses', 'selesai'])
            ->get();

        // Menyiapkan data JSON
        $data = $transactions->map(function ($transaction) {
            return [
                'id' => $transaction->id,
                'order_name' => $transaction->order_name,
                'order_whatsapp' => $transaction->order_whatsapp,
                'installation_address' => $transaction->installation_address,
                'district' => $transaction->district->name ?? 'Tidak Diketahui',
                'total_amount' => $transaction->total_amount,
                'status' => $transaction->status,
                'rentals' => $transaction->rentals->map(function ($rental) use ($transaction) {
                    return [
                        'rental_date' => $rental->rental_date,
                        'return_date' => $rental->return_date,
                        'transaction_id' => $transaction->id,
                        'produk' => $rental->produk ? [
                            'id' => $rental->produk->id,
                            'name' => $rental->produk->name,
                        ] : null, // Menangani jika produk tidak ada
                    ];
                }),
            ];
        });

        return response()->json($data);
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $data['produks'] = Produk::all();
        $data['districts'] = District::all();
        $data['cartItems'] = CartItem::where('user_id', $user->id)->with('produk')->get();
        $data['rentals'] = Rentals::with(['produk', 'transaction'])
            ->whereHas('transaction', function ($query) {
                $query->whereIn('status', ['disetujui', 'diproses', 'selesai']);
            })
            ->get();

        return view('layouts.main.transaksi.checkout', $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $request->validate([
            'order_name' => 'required|string|max:255',
            'order_whatsapp' => 'required|string|max:15',
            'district_id' => 'required|exists:districts,id',
            'installation_address' => 'required|string',
            'rental_date' => 'required|date',
            'rental_days' => 'required|integer|min:1',
            'products' => 'required|array',
            'products.*.produk_id' => 'required|exists:produks,id',
        ]);

        try {
            $user = Auth::user();
            $totalAmount = 0;
            $rental_date = Carbon::parse($request->rental_date);
            $rental_days = (int) $request->rental_days; // Konversi ke integer
            $return_date = $rental_date->copy()->addDays($rental_days - 1);

            $transaction = Transactions::create([
                'user_id' => $user->id,
                'order_name' => $request->order_name,
                'order_whatsapp' => $request->order_whatsapp,
                'district_id' => $request->district_id,
                'installation_address' => $request->installation_address,
                'status' => 'menunggu',
                'total_amount' => $totalAmount, // Inisialisasi dengan nilai 0
            ]);

            foreach ($request->products as $product) {
                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    Rentals::create([
                        'transactions_id' => $transaction->id,
                        'produk_id' => $product['produk_id'],
                        'rental_days' => $rental_days,
                        'rental_date' => $rental_date,
                        'return_date' => $return_date,
                        'location' => $transaction->installation_address,
                        'delivery_fee' => $transaction->district ? $transaction->district->delivery_fee : 0,
                    ]);
                    $totalAmount += ($produk->price * $rental_days);
                }
            }

            // Tambahkan ongkir ke total amount
            $totalAmount += $transaction->district ? $transaction->district->delivery_fee : 0;
            // Perbarui total_amount pada transaksi
            $transaction->total_amount = $totalAmount;
            $transaction->save();

            // Hapus keranjang setelah transaksi berhasil
            CartItem::where('user_id', $user->id)->delete();

            // Kirim notifikasi ke admin
            $admin = User::where('is_role', 'admin')->get();
            foreach ($admin as $a) {
                $a->notify(new NewTransactionNotification($transaction));
            }

            return redirect()->route('customer.transactions.index')->with('success', 'Transaksi berhasil dibuat. Menunggu konfirmasi dari admin.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan saat membuat transaksi. Silakan coba lagi.']);
        }
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
