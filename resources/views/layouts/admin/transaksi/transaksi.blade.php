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
                    <th>Status</th>
                    <th>Total Jumlah</th>
                    <th>Tanggal Transaksi</th>
                </tr>
            </thead>
            <tbody>
                <!-- Loop data transaksi di sini -->
                @foreach ($transactions as $transaction)
                    <tr>
                        <td>{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                        <td>{{ $transaction->created_at->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
