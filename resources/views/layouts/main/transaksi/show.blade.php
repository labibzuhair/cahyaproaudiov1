@extends('layouts.main.master.master')

@section('title', 'Detail Transaksi')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h2>Detail Transaksi</h2>
            <a href="{{ route('customer.transactions.index') }}" class="btn btn-primary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="table-responsive">
            <table class="table table-hover table-bordered text-center">
                <thead class="table-dark">
                    <tr>
                        <th>Nama Produk</th>
                        <th>Jumlah Hari Rental</th>
                        <th>Harga Per Hari</th>
                        <th>Total Harga</th>
                        <th>Ongkir</th>
                        <th>Lokasi</th>
                        <th>Tanggal Penyewaan</th>
                        <th>Tanggal Pengembalian</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaction->rentals as $rental)
                        <tr>
                            <td>{{ $rental->produk->name }}</td>
                            <td>{{ $rental->rental_days }}</td>
                            <td>Rp {{ number_format($rental->produk->price, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($rental->produk->price * $rental->rental_days, 0, ',', '.') }}</td>
                            <td>Rp {{ number_format($rental->delivery_fee, 0, ',', '.') }}</td>
                            <td>{{ $rental->location }}</td>
                            <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d-m-Y') }}</td>
                            <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d-m-Y') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
