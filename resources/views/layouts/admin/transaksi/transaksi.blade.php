@extends('layouts.admin.master.master')

@section('title', 'Transaksi')

@section('content')
    <div class="container mt-5">

        <h1 class="mb-4">Transaksi</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID Transaksi</th>
                    <th>Nama Pelanggan</th>
                    <th>Atas Nama Sewa</th>
                    <th>No WhatsApp</th>
                    <th>Status</th>
                    <th>Lokasi</th>
                    <th>Tanggal Transaksi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ optional($transaction->user)->name ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $transaction->order_name }}</td>
                        <td>{{ $transaction->order_whatsapp }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ optional($transaction->district)->name ?? 'Tidak Diketahui' }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <a href="{{ route('admin.transactions.show', $transaction->id) }}"
                                    class="btn btn-success btn-sm">
                                    <i class="fa-solid fa-circle-info"></i>
                                </a>
                                <a href="{{ route('admin.transactions.edit', $transaction->id) }}"
                                    class="btn btn-warning btn-sm">
                                    <i class="fa-solid fa-pen-to-square"></i>
                                </a>
                                <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST"
                                    novalidate style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
                                        <i class="fa-solid fa-trash-can"></i>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="container mt-5">
        {{-- <h1 class="mb-4">Detail Transaksi</h1>
        <div class="card mb-4">
            <div class="card-header">
                Detail Transaksi
            </div>
            <div class="card-body">
                <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                <p><strong>Nama Pelanggan:</strong> {{ $transaction->user->name }}</p>
                <p><strong>Atas Nama Sewa:</strong> {{ $transaction->order_name }}</p>
                <p><strong>No WhatsApp:</strong> {{ $transaction->order_whatsapp }}</p>
                <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
                <p><strong>Lokasi:</strong> {{ $transaction->district ? $transaction->district->name : 'Tidak Diketahui' }}
                </p>
                <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
                <p><strong>Total Amount:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
            </div>
        </div> --}}

        <div class="card mb-4">
            <div class="card-header">
                Perubahan yang Dilakukan oleh User
            </div>
            <div class="card-body">
                @if ($changes->isEmpty())
                    <p>Tidak ada perubahan yang dilakukan oleh user.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Nilai Lama</th>
                                <th>Nilai Baru</th>
                                <th>Tanggal Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($changes as $change)
                                <tr>
                                    <td>{{ $change->field }}</td>
                                    <td>{{ $change->old_value }}</td>
                                    <td>{{ $change->new_value }}</td>
                                    <td>{{ $change->created_at->format('d-m-Y H:i:s') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        @if ($transaction->status === 'menunggu')
                            <form action="{{ route('admin.transactions.approve_all', $transaction->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-success">Setujui Semua</button>
                            </form>
                            <form action="{{ route('admin.transactions.reject_all', $transaction->id) }}" method="POST"
                                style="display:inline;">
                                @csrf
                                @method('POST')
                                <button type="submit" class="btn btn-danger">Tolak Semua</button>
                            </form>
                        @endif
                    </div>
                @endif
            </div>

            {{-- <div class="card">
            <div class="card-header">
                Produk yang Disewa
            </div>
            <div class="card-body">
                <table class="table table-striped">
                    <thead>
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
                <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary">Kembali</a>
            </div>
        </div> --}}
        </div>
    @endsection
