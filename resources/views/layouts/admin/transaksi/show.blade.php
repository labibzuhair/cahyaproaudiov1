@extends('layouts.admin.master.master')

@section('title', 'Detail Transaksi')

@section('content')
    <section class="intro">
        <div class="bg-image h-100" style="background-color: #f5f7fa;">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <h1 class="mb-4 text-center">Detail Transaksi</h1>
                                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                                        <table class="table table-striped mb-0">
                                            <thead style="background-color: #002d72;">
                                                <tr>
                                                    <th scope="col">Nama Produk</th>
                                                    <th scope="col">Jumlah Hari Rental</th>
                                                    <th scope="col">Harga Per Hari</th>
                                                    <th scope="col">Total Harga</th>
                                                    <th scope="col">Ongkir</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Tanggal Penyewaan</th>
                                                    <th scope="col">Tanggal Pengembalian</th>
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
                                    <div class="text-center mt-4">
                                        <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary">Kembali</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
