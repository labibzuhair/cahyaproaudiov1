<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('produk')->get();
        return view('layouts.main.transaksi.keranjang', compact('cartItems'));
    }

    public function add(Request $request, $produkId)
    {
        $user = auth()->user();
        $cartItem = CartItem::firstOrCreate(
            ['user_id' => $user->id, 'produk_id' => $produkId],
            ['quantity' => 1]
        );
        $cartItem->quantity += 1;
        $cartItem->save();

        return response()->json(['message' => 'Produk berhasil ditambahkan ke keranjang!']);
    }

    public function remove(Request $request, $produkId)
    {
        $user = auth()->user();
        $cartItem = CartItem::where('user_id', $user->id)->where('produk_id', $produkId)->first();

        if ($cartItem) {
            $cartItem->delete();
            return response()->json(['message' => 'Produk berhasil dihapus dari keranjang!']);
        }

        return response()->json(['message' => 'Produk tidak ditemukan di keranjang!'], 404);
    }
}






