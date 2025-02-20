@extends('layouts.admin.master.master')


@section('title', 'History')

@section('content')

    <div class="container mt-5">
        <h1 class="mb-4">History Transaksi</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Produk</th>
                    <th>Tanggal Penyewaan</th>
                    <th>Tanggal Pengembalian</th>
                    <th>Lokasi</th>
                    <th>Jumlah</th>
                    <th>Total Harga</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop data riwayat transaksi di sini -->
                @foreach($rentals as $rental)
                    <tr>
                        <td>{{ $rental->transaction ? $rental->transaction->id : 'Tidak Diketahui' }}</td>
                        <td>{{ $rental->transaction && $rental->transaction->user ? $rental->transaction->user->name : 'Tidak Diketahui' }}
                        </td>
                        <td>{{ $rental->produk->name }}</td>
                        <td>{{ $rental->rental_date }}</td>
                        <td>{{ $rental->return_date }}</td>
                        <td>{{ $rental->location }}</td>
                        <td>{{ $rental->quantity }}</td>
                        <td>Rp {{ number_format($rental->price * $rental->quantity, 0, ',', '.') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
