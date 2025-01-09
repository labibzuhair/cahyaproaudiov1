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
                        <td>{{ $transaction->user ? $transaction->user->name : 'Tidak Diketahui' }}</td>
                        <td>{{ $transaction->order_name }}</td>
                        <td>{{ $transaction->order_whatsapp }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ $transaction->district ? $transaction->district->name : 'Tidak Diketahui' }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}</td>
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
                                    style="display:inline;">
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
@endsection
