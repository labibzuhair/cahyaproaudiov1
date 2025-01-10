<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Rentals;
use App\Models\CartItem;
use App\Models\District;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['order_name' => 'required|string|max:255', 'order_whatsapp' => 'required|string|max:15', 'district_id' => 'required|exists:districts,id', 'installation_address' => 'required|string', 'rental_date' => 'required|date', 'rental_days' => 'required|integer|min:1',]);
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('produk')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang belanja Anda kosong.');
        }
        // Buat transaksi baru
        $transaction = Transactions::create([
            'user_id' => $user->id,
            'order_name' => $request->order_name,
            'order_whatsapp' => $request->order_whatsapp,
            'installation_address' => $request->installation_address,
            'district_id' => $request->district_id,
            'total_amount' => 0, // Placeholder, akan diperbarui di bawah
            'status' => 'pending',
        ]);
        // Ambil ongkir berdasarkan kecamatan
        $district = District::find($request->district_id);
        $delivery_fee = $district ? $district->delivery_fee : 0;
        // Tambahkan rental items ke transaksi
        $totalAmount = 0;
        $rental_date = Carbon::parse($request->rental_date);
        $rental_days = (int) $request->rental_days;
        $return_date = $rental_date->copy()->addDays($rental_days - 1);
        foreach ($cartItems as $cartItem) {
            $produk = $cartItem->produk;
            if ($produk) {
                Rentals::create(['transactions_id' => $transaction->id, 'produk_id' => $produk->id, 'rental_date' => $rental_date, 'return_date' => $return_date, 'rental_days' => $rental_days, 'location' => $request->installation_address, 'delivery_fee' => $delivery_fee,]);
                $totalAmount += ($produk->price * $rental_days * $cartItem->quantity);
            }
        }
        // Tambahkan ongkir ke total amount
        $totalAmount += $delivery_fee; // Perbarui total_amount pada transaksi
        $transaction->total_amount = $totalAmount;
        $transaction->save();
        // Hapus item dari keranjang
        CartItem::where('user_id', $user->id)->delete();
        return redirect()->route('layots.main.transaksi.index')->with('success', 'Transaksi berhasil dibuat.');
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
