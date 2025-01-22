@extends('layouts.main.master.master')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <h2 class="text-center">Form Pemesanan</h2>
        <form action="{{ route('customer.checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="form-group">
                <label for="order_name">Nama Pemesan</label>
                <input type="text" class="form-control" id="order_name" name="order_name" required>
            </div>
            <div class="form-group">
                <label for="order_whatsapp">No WhatsApp</label>
                <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp" required>
            </div>
            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select class="form-control" id="district_id" name="district_id" required>
                    <option selected disabled>Pilih Kecamatan</option>


                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
            <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
        </div>

        <h3 class="mt-4">Produk yang Dipesan</h3>
        @foreach ($cartItems as $index => $item)
            <div class="product-group mb-3">
                <div class="form-group">
                    <label for="produk_id">Produk</label>
                    <input type="text" class="form-control" value="{{ $item->produk->name }}" readonly>
                    <input type="hidden" name="products[{{ $index }}][produk_id]"
                        value="{{ $item->produk_id }}">
                    <input type="hidden" name="products[{{ $index }}][quantity]"
                        value="{{ $item->quantity }}">
                </div>
            </div>
        @endforeach

        <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
        <div class="form-group">
            <label for="rental_date">Tanggal Rental</label>
            <input type="date" class="form-control" id="rental_date" name="rental_date" required>
        </div>
        <div class="form-group">
            <label for="rental_days">Jumlah Hari Rental</label>
            <input type="number" class="form-control" id="rental_days" name="rental_days" required min="1">
        </div>

        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>
@endsection
