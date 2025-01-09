<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\District;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DistrictController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $data['getRecord'] = User::find($user->id);
        $data['districts'] = District::all();
        return view('layouts.admin.districts.index', $data);
    }
    public function store(Request $request)
    {
        $request->validate(['name' => 'required|string|max:255', 'delivery_fee' => 'required|numeric',]);
        District::create(['name' => $request->name, 'delivery_fee' => $request->delivery_fee,]);
        return redirect()->route('admin.districts.index')->with('success', 'Kecamatan berhasil ditambahkan');
    }
    public function update(Request $request, $id)
    {
        $request->validate(['delivery_fee' => 'required|numeric',]);
        $district = District::findOrFail($id);
        $district->update(['delivery_fee' => $request->delivery_fee,]);
        return redirect()->route('admin.districts.index')->with('success', 'Harga per kecamatan berhasil diperbarui');
    }
}
