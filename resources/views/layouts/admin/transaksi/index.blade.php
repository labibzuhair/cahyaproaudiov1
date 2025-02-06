@extends('layouts.admin.master.master')

@section('title', 'Transaksi')

@section('content')
    <section class="intro">
        <div class="bg-image h-100" style="background-color: #f5f7fa;">
            <div class="mask d-flex align-items-center h-100">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body p-0">
                                    <h1 class="mb-4 text-center">Transaksi</h1>
                                    <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 600px">
                                        <table class="table table-striped mb-0">
                                            <thead style="background-color: #002d72;">
                                                <tr>
                                                    <th scope="col">ID Transaksi</th>
                                                    <th scope="col">Nama Pelanggan</th>
                                                    <th scope="col">Atas Nama Sewa</th>
                                                    <th scope="col">No WhatsApp</th>
                                                    <th scope="col">Status</th>
                                                    <th scope="col">Lokasi</th>
                                                    <th scope="col">Tanggal Transaksi</th>
                                                    <th scope="col">Aksi</th>
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
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
