@extends('layouts.main.master.master')


@section('title', 'Keranjang')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <h2 class="text-center">Keranjang Belanja</h2>
        <div id="cart-container">
            @if ($cartItems->isEmpty())
                <p class="text-center">Keranjang belanja Anda kosong.</p>
            @else
                @include('layouts.components.main.cart', ['cartItems' => $cartItems])
            @endif
        </div>

        <div class="mt-5">
            <h3 class="text-center">Rekomendasi Produk</h3>
            <div id="recommendations-container">
                @include('layouts.components.main.recommendations', [
                    'recommendedProduks' => $recommendedProduks,
                ])
            </div>
        </div>
    </div>
@endsection
