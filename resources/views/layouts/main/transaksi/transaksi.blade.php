@extends('layouts.main.master.master')

@section('title', 'Transaksi Saya')

@section('content')

<section class="intro">
    <div class="bg-image h-100" style="background-color: #f5f7fa;">
        <div class="mask d-flex align-items-center h-100">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body p-0">
                                <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 600px;">
                                    @if ($transactions->isEmpty())
                                        <p class="text-center p-3">Anda belum memiliki transaksi.</p>
                                    @else
                                        <table class="table table-striped mb-0">
                                            <thead style="background-color: #002d72; color: white;">
                                                <tr>
                                                    <th scope="col">No</th>
                                                    <th scope="col">Nama Pemesan</th>
                                                    <th scope="col">No WhatsApp</th>
                                                    <th scope="col">Alamat Pemasangan</th>
                                                    <th scope="col">Kecamatan</th>
                                                    <th scope="col">Total Harga</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Tanggal Transaksi</th>
                                                    <th scope="col">Aksi</th>
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
                                                            <div class="btn-group" role="group">
                                                                <a href="{{ route('customer.transactions.show', $transaction->id) }}" class="btn btn-success btn-sm">
                                                                    <i class="fa-solid fa-circle-info"></i>
                                                                </a>
                                                                <a href="{{ route('customer.transactions.edit', $transaction->id) }}" class="btn btn-warning btn-sm">
                                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                                </a>
                                                                <form action="{{ route('customer.transactions.request-delete', $transaction->id) }}" method="POST" style="display:inline;">
                                                                    @csrf
                                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin mengajukan permintaan penghapusan transaksi ini?')">
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
