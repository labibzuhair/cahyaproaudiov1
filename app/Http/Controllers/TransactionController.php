<?php

namespace App\Http\Controllers;

use Exception;

use Carbon\Carbon;
use App\Models\User;
use App\Models\produk;
use App\Models\Rentals;
use App\Models\District;
use App\Models\Transactions;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $transactions = Transactions::where('user_id', $user->id)->with('rentals.produk', 'district')->get();
        return view('layouts.main.transaksi.transaksi', compact('transactions'));
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->with('rentals.produk')->firstOrFail();
        return view('layouts.main.transaksi.show', compact('transaction'));
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->with('rentals.produk')->firstOrFail();
        $districts = District::all();
        $produks = Produk::whereNotIn('id', $transaction->rentals->pluck('produk_id'))->get(); // Produk lain
        return view('layouts.main.transaksi.edit', compact('transaction', 'districts', 'produks'));
    }

    public function update(Request $request, $id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

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
            // Perbarui transaksi dengan status 'menunggu'
            $transaction->update([
                'order_name' => $request->order_name,
                'order_whatsapp' => $request->order_whatsapp,
                'district_id' => $request->district_id,
                'installation_address' => $request->installation_address,
                'status' => 'menunggu',
            ]);

            // Hapus rental items yang ada
            $transaction->rentals()->delete();

            // Tambahkan rental items baru ke transaksi
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

            return redirect()->route('customer.transactions.index')->with('success', 'Perubahan berhasil diajukan. Menunggu konfirmasi dari admin.');
        } catch (Exception $e) {
            return back()->withInput()->withErrors(['msg' => 'Terjadi kesalahan saat memperbarui transaksi. Silakan coba lagi.']);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function requestDelete($id)
    {
        $transaction = Transactions::where('id', $id)->where('user_id', Auth::id())->firstOrFail();
        $transaction->status = 'menunggu';
        $transaction->save();
        return redirect()->route('customer.transactions.index')->with('success', 'Permintaan penghapusan transaksi berhasil diajukan. Menunggu konfirmasi admin.');
    }
}
