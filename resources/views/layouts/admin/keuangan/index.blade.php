@extends('layouts.admin.master.master')


@section('title', 'Keuangan')

@section('content')
<div class="container">
    <h2>Dashboard Keuangan</h2>

    <div class="row">
        <!-- Kartu Total Pemasukan -->
        <div class="col-md-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pemasukan</h5>
                    <h3>Rp {{ number_format($incomeTotal, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>

        <!-- Kartu Total Pengeluaran -->
        <div class="col-md-4">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <h5 class="card-title">Total Pengeluaran</h5>
                    <h3>Rp {{ number_format($expenseTotal, 0, ',', '.') }}</h3>
                </div>
            </div>
        </div>
    </div>

    <h3 class="mt-4">Laporan Keuangan</h3>
    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Pemasukan</th>
                <th>Total Pengeluaran</th>
                <th>Keuntungan Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($financialReports as $report)
            <tr>
                <td>{{ date('F', mktime(0, 0, 0, $report->month, 1)) }}</td>
                <td>{{ $report->year }}</td>
                <td>Rp {{ number_format($report->total_income, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($report->total_expense, 0, ',', '.') }}</td>
                <td>Rp {{ number_format($report->net_profit, 0, ',', '.') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection

