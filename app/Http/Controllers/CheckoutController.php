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


class CheckoutController extends Controller
{
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
        return view('layouts.main.transaksi.checkout', $data);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        try {
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

            // Buat transaksi baru
            $transaction = Transactions::create([
                'user_id' => auth()->id(),
                'order_name' => $request->order_name,
                'order_whatsapp' => $request->order_whatsapp,
                'installation_address' => $request->installation_address,
                'district_id' => $request->district_id,
                'total_amount' => 0, // Placeholder, akan diperbarui di bawah
            ]);

            // Ambil ongkir berdasarkan kecamatan
            $district = District::find($request->district_id);
            $delivery_fee = $district ? $district->delivery_fee : 0;

            // Tambahkan rental items ke transaksi
            $totalAmount = 0;
            $rental_date = Carbon::parse($request->rental_date);
            $rental_days = (int) $request->rental_days; // Konversi ke integer
            $return_date = $rental_date->copy()->addDays($rental_days - 1);
            foreach ($request->products as $product) {
                $produk = Produk::find($product['produk_id']);
                if ($produk) {
                    $rental = Rentals::create([
                        'transactions_id' => $transaction->id,
                        'produk_id' => $product['produk_id'],
                        'rental_date' => $rental_date,
                        'return_date' => $return_date,
                        'rental_days' => $rental_days,
                        'location' => $request->installation_address,
                        'delivery_fee' => $delivery_fee,
                    ]);
                    $totalAmount += ($produk->price * $rental_days);
                } else {
                    throw new Exception("Produk dengan ID {$product['produk_id']} tidak ditemukan.");
                }
            }

            // Tambahkan ongkir ke total amount
            $totalAmount += $delivery_fee;
            // Perbarui total_amount pada transaksi
            $transaction->total_amount = $totalAmount;
            $transaction->save();

            // Hapus semua item di keranjang setelah checkout berhasil
            CartItem::where('user_id', auth()->id())->delete();

            return redirect()->route('customer.transactions.index'); // Mengarahkan ke halaman transaksi
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan saat memproses transaksi. Silakan coba lagi.']);
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
