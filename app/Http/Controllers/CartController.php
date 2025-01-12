<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\produk;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CartController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('produk')->get();
        $produkIdsInCart = $cartItems->pluck('produk_id')->toArray();
        $recommendedProduks = Produk::whereNotIn('id', $produkIdsInCart)->get();
        return view('layouts.main.transaksi.keranjang', compact('cartItems', 'recommendedProduks'));
    }
    public function add(Request $request, $produkId)
    {
        $user = auth()->user();
        $cartItem = CartItem::where('user_id', $user->id)->where('produk_id', $produkId)->first();
        if ($cartItem) {
            $cartItem->quantity += 1;
            $cartItem->save();
        } else {
            CartItem::create(['user_id' => $user->id, 'produk_id' => $produkId, 'quantity' => 1]);
        }
        return $this->generateCartResponse();
    }
    public function remove(Request $request, $produkId)
    {
        $user = auth()->user();
        $cartItem = CartItem::where('user_id', $user->id)->where('produk_id', $produkId)->first();
        if ($cartItem) {
            $cartItem->delete();
        }
        return $this->generateCartResponse();
    }
    private function generateCartResponse()
    {
        $user = auth()->user();
        $cartItems = CartItem::where('user_id', $user->id)->with('produk')->get();
        $recommendedProduks = Produk::whereNotIn('id', $cartItems->pluck('produk_id')->toArray())->get();
        $cartHtml = view('layouts.components.main.cart', compact('cartItems'))->render();
        $recommendationsHtml = view('layouts.components.main.recommendations', compact('recommendedProduks'))->render();
        return response()->json(['cartHtml' => $cartHtml, 'recommendationsHtml' => $recommendationsHtml]);
    }
}



