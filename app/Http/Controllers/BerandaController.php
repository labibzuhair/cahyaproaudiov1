<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\produk;
use App\Models\CartItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

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

        // Apply search and filter
        $query = Produk::query();
        $data['produks'] = $query->get();

        // Ambil produk yang ada di keranjang untuk user yang sedang login
        $cartItems = CartItem::where('user_id', $user->id)->pluck('produk_id')->toArray();
        $data['cartItems'] = $cartItems;

        if ($user) {
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
