@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Manajemen Keuangan</h1>
    <div class="row mt-3">
        <div class="col-md-4">
            <a href="{{ route('admin.finance.expense') }}" class="btn btn-danger btn-block">
                <i class="fas fa-money-bill-wave"></i> Tambah Pengeluaran
            </a>
        </div>
        <div class="col-md-4">
            <a href="{{ route('admin.finance.report') }}" class="btn btn-primary btn-block">
                <i class="fas fa-file-alt"></i> Laporan Keuangan
            </a>
        </div>
    </div>

    <hr>

    <h3 class="mt-4">Pemasukan</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($incomes as $income)
                <tr>
                    <td>{{ $income->date }}</td>
                    <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                    <td>{{ $income->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h3 class="mt-4">Pengeluaran</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $expense->date }}</td>
                    <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                    <td>{{ $expense->category }}</td>
                    <td>{{ $expense->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

</div>
@endsection
