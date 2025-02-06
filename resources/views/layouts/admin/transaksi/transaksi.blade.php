@extends('layouts.admin.master.master')

@section('title', 'Detail Transaksi')

@section('content')
    <section class="intro">
        <div class="bg-image h-100" style="background-color: #f5f7fa;">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <h1 class="text-center mb-5">Detail Transaksi</h1>
                    <div class="row">
                        <div class="col-md-6">
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
                                    <p><strong>Lokasi:</strong> {{ $transaction->district ? $transaction->district->name : 'Tidak Diketahui' }}</p>
                                    <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
                                    <p><strong>Total Amount:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
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
                                                <form action="{{ route('admin.transactions.approve_all', $transaction->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-success">Setujui Semua</button>
                                                </form>
                                                <form action="{{ route('admin.transactions.reject_all', $transaction->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('POST')
                                                    <button type="submit" class="btn btn-danger">Tolak Semua</button>
                                                </form>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <h1 class="text-center mb-5">Daftar Transaksi</h1>
                    <div class="card">
                        <div class="card-body">
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
                                                    <a href="{{ route('admin.transactions.show', $transaction->id) }}" class="btn btn-success btn-sm">
                                                        <i class="fa-solid fa-circle-info"></i>
                                                    </a>
                                                    <a href="{{ route('admin.transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                                        <i class="fa-solid fa-pen-to-square"></i>
                                                    </a>
                                                    <form action="{{ route('admin.transactions.destroy', $transaction->id) }}" method="POST" novalidate style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus transaksi ini?')">
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
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
