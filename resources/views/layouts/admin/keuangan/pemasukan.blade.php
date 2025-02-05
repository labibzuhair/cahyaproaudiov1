@extends('layouts.admin.master.master')

@section('title', 'Riwayat Pemasukan')

@section('content')
<div class="container">
    <h2>Riwayat Pemasukan</h2>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($incomes as $income)
            <tr>
                <td>{{ $income->date }}</td>
                <td>Rp {{ number_format($income->amount, 0, ',', '.') }}</td>
                <td>{{ $income->description }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
