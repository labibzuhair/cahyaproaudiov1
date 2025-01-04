<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;
use App\Models\Rentals;
use App\Models\produk;


class TransactionsController extends Controller
{
    public function index()
    {
        $transactions = Transactions::with(['user', 'rentals.produk'])->get();
        return view('layouts.main.transaksi.transaksi', compact('transactions'));
    }

    public function create()
    {
        $produks = Produk::all();
        return view('layouts.main.transaksi.create', compact('produks'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'order_name' => 'required|string|max:255',
            'order_whatsapp' => 'required|string|max:15',
            'installation_address' => 'required|string',
            'products' => 'required|array',
            'products.*.produk_id' => 'required|exists:produks,id',
            'products.*.quantity' => 'required|integer|min:1',
            'status' => 'required|in:pending,completed,cancelled',
        ]);

        // Buat transaksi baru 
        $transaction = Transactions::create([
            'user_id' => auth()->id(),
            'order_name' => $request->order_name,
            'order_whatsapp' => $request->order_whatsapp,
            'installation_address' => $request->installation_address,
            'total_amount' => 0,
            'status' => $request->status,
        ]);

        // Tambahkan rental items ke transaksi 
        $totalAmount = 0;
        foreach ($request->products as $product) {
            $produk = Produk::find($product['produk_id']);
            if ($produk) {
                $rental = Rentals::create([
                    'transactions_id' => $transaction->id,
                    'produk_id' => $product['produk_id'],
                    'rental_date' => now(),
                    'return_date' => now()->addDays(1),
                    'location' => $request->installation_address,
                    'price' => $produk->price,
                    'quantity' => $product['quantity'],
                ]);
                $totalAmount += $produk->price * $product['quantity'];
            }
        }

        // Perbarui total_amount pada transaksi 
        $transaction->total_amount = $totalAmount;
        $transaction->save();

        return redirect()->route('transactions.index');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
