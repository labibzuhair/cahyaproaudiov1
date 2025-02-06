@extends('layouts.main.master.master')

@section('title', 'Keranjang')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <div class="row" style="    margin-right: -50px;
    margin-left: -50px;">
            <!-- Keranjang Belanja (Kiri) -->
            <div class="col-lg-7 col-md-12 " id="cart-section">
                <h2 class="text-center">Keranjang Belanja</h2>
                <div id="cart-container">
                    @if ($cartItems->isEmpty())
                        <p class="text-center">Keranjang belanja Anda kosong.</p>
                    @else
                        @include('layouts.components.main.cart', ['cartItems' => $cartItems])
                    @endif
                </div>
            </div>

            <!-- Rekomendasi Produk (Kanan) -->
            <div class="col-lg-5 col-md-12 col-sm-12 rek-produk">
                <h3 class="text-center">Rekomendasi Produk</h3>
                <div id="recommendations-container" class="sticky-recommendations">
                    @if ($recommendedProduks->isEmpty())
                        <p class="text-center text-muted">Semua Produk Telah Dimasukkan ke Keranjang. Silahkan Checkout
                            Terlebih Dahulu Untuk Membuat Transaksi Lagi.</p>
                    @else
                        @include('layouts.components.main.recommendations', [
                            'recommendedProduks' => $recommendedProduks,
                        ])
                    @endif
                </div>
            </div>
        </div>
    </div>

    <style>
        /* Background untuk seluruh halaman */
        body {
            background-color: #f4f4f4;
        }

        /* Background untuk keranjang belanja */
        #cart-section {
            background-color: #ffffff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Background untuk rekomendasi produk */
        .rek-produk {
            background-color: #f9f9f9;
            padding-left: 30px;
            padding-right: 30px;
            padding-top: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        /* Sticky untuk rekomendasi produk */
        .sticky-recommendations {
            height: 70vh;
            overflow-y: auto;
            overflow-x: hidden;
            position: sticky;
            top: 70px;
        }

        /* Memperkecil ukuran elemen produk */
        .card {
            max-width: 300px;
            margin: 0 auto;
            border-radius: 8px;
        }

        .card-img-top {
            width: 91%;
            margin: 0 auto;
        }

        /* Memperkecil ukuran font pada tabel */
        .table td,
        .table th {
            font-size: 0.875rem;
        }

        /* Memperkecil ukuran tombol hapus */
        .dell {
            font-size: 0.75rem;
            padding: 5px 10px;
            border-radius: 4px;
        }

        /* Menyesuaikan ukuran ikon pada tombol hapus */
        .dell i {
            font-size: 0.875rem;
        }

        /* Responsif untuk kolom keranjang dan rekomendasi produk */
        @media (max-width: 991px) {
            .rek-produk {
                padding-left: 15px;
                padding-right: 15px;
            }

            .card {
                width: 100%;
            }
        }

        /* Responsif untuk tablet */
        @media (max-width: 767px) {
            .rek-produk {
                padding-left: 15px;
                padding-right: 15px;
            }

            .card {
                width: 100%;
            }

            .text-center {
                font-size: 1rem;
            }
        }

        /* Responsif untuk handphone (lebih kecil dari tablet) */
        @media (max-width: 575px) {
            #cart-section,
            .rek-produk {
                padding-left: 10px;
                padding-right: 10px;
            }

            .card {
                width: 100%;
            }

            .text-center {
                font-size: 0.9rem;
            }

            /* Memperbesar margin bawah untuk elemen */
            .col-md-12 {
                margin-bottom: 10px;
            }

            .sticky-recommendations {
                height: auto;
                /* Menyesuaikan tinggi rekomendasi produk agar tidak terlalu panjang */
            }
        }
    </style>
@endsection
