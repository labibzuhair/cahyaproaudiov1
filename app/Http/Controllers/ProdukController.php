<?php

namespace App\Http\Controllers;

use App\Models\produk;
use Illuminate\Routing\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreprodukRequest;
use App\Http\Requests\UpdateprodukRequest;

class ProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data produk dari database
        $user = Auth::user();
        $data['getRecord'] = User::find($user->id);
        $data['produks'] = Produk::all();

        // Kirim data produk ke view
        return view('layouts.admin.produks.produks', $data);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $data['getRecord'] = User::find($user->id);
        return view('layouts.admin.produks.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string|in:sound,tenda,dekorasi',
            'stock' => 'required|integer',
            'photo_main' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Simpan foto ke direktori
        $photoMain = $request->file('photo_main')->store('images/produk', 'public');
        $photo1 = $request->file('photo_1') ? $request->file('photo_1')->store('images/produk', 'public') : null;
        $photo2 = $request->file('photo_2') ? $request->file('photo_2')->store('images/produk', 'public') : null;
        $photo3 = $request->file('photo_3') ? $request->file('photo_3')->store('images/produk', 'public') : null;
        $photo4 = $request->file('photo_4') ? $request->file('photo_4')->store('images/produk', 'public') : null;

        // Simpan data ke database
        Produk::create([
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'type' => $request->type,
            'stock' => $request->stock,
            'photo_main' => $photoMain,
            'photo_1' => $photo1,
            'photo_2' => $photo2,
            'photo_3' => $photo3,
            'photo_4' => $photo4,
        ]);

        return redirect()->back()->with('success', 'Product created successfully.');
    }


    /**
     * Display the specified resource.
     */
    public function show(produk $produk)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $user = Auth::user();
        $data = [
            'getRecord' => User::find($user->id),
            'produk' => Produk::findOrFail($id),
        ];

        return view('layouts.admin.produks.edit', $data);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'type' => 'required|string|in:sound,tenda,dekorasi',
            'stock' => 'required|integer',
            'photo_main' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_1' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_2' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_3' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'photo_4' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_photo_1' => 'sometimes|boolean',
            'remove_photo_2' => 'sometimes|boolean',
            'remove_photo_3' => 'sometimes|boolean',
            'remove_photo_4' => 'sometimes|boolean',
        ]);

        $produk = Produk::findOrFail($id);

        // Simpan foto ke direktori publik
        if ($request->hasFile('photo_main')) {
            $photoMain = $request->file('photo_main')->store('images/produk', 'public');
            $produk->photo_main = $photoMain;
        }

        if ($request->hasFile('photo_1')) {
            $photo1 = $request->file('photo_1')->store('images/produk', 'public');
            $produk->photo_1 = $photo1;
        }

        if ($request->hasFile('photo_2')) {
            $photo2 = $request->file('photo_2')->store('images/produk', 'public');
            $produk->photo_2 = $photo2;
        }

        if ($request->hasFile('photo_3')) {
            $photo3 = $request->file('photo_3')->store('images/produk', 'public');
            $produk->photo_3 = $photo3;
        }

        if ($request->hasFile('photo_4')) {
            $photo4 = $request->file('photo_4')->store('images/produk', 'public');
            $produk->photo_4 = $photo4;
        }

        // Hapus foto jika diminta
        if ($request->input('remove_photo_1')) {
            $produk->photo_1 = null;
        }

        if ($request->input('remove_photo_2')) {
            $produk->photo_2 = null;
        }

        if ($request->input('remove_photo_3')) {
            $produk->photo_3 = null;
        }

        if ($request->input('remove_photo_4')) {
            $produk->photo_4 = null;
        }

        // Update data di database
        $produk->name = $request->name;
        $produk->description = $request->description;
        $produk->price = $request->price;
        $produk->type = $request->type;
        $produk->stock = $request->stock;
        $produk->save();

        return redirect()->route('admin.produks.index')->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produk = Produk::findOrFail($id);
        $produk->delete();
        return redirect()->route('admin.produks.index')->with('success', 'Product deleted successfully.');
    }
}
