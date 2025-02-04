@extends('layouts.main.master.master')

@section('title', 'Transaksi Saya')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <h2 class="text-center">Transaksi Saya</h2>
        @if ($transactions->isEmpty())
            <p class="text-center">Anda belum memiliki transaksi.</p>
        @else
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Pemesan</th>
                        <th>No WhatsApp</th>
                        <th>Alamat Pemasangan</th>
                        <th>Kecamatan</th>
                        <th>Total Harga</th>
                        <th>Status</th>
                        <th>Tanggal Transaksi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions as $transaction)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transaction->order_name }}</td>
                            <td>{{ $transaction->order_whatsapp }}</td>
                            <td>{{ $transaction->installation_address }}</td>
                            <td>{{ $transaction->district ? $transaction->district->name : 'Tidak Diketahui' }}</td>
                            <td>Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</td>
                            <td>{{ ucfirst($transaction->status) }}</td>
                            <td>{{ \Carbon\Carbon::parse($transaction->created_at)->format('d-m-Y') }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                    <a href="{{ route('customer.transactions.show', $transaction->id) }}"
                                        class="btn btn-success btn-sm">
                                        <i class="fa-solid fa-circle-info"></i>
                                    </a>
                                    <a href="{{ route('customer.transactions.edit', $transaction->id) }}"
                                        class="btn btn-warning btn-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('customer.transactions.request-delete', $transaction->id) }}"
                                        method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-danger btn-sm"
                                            onclick="return confirm('Apakah Anda yakin ingin mengajukan permintaan penghapusan transaksi ini?')">
                                            <i class="fa-solid fa-trash-can"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
