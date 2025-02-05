@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Laporan Keuangan</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Bulan</th>
                <th>Tahun</th>
                <th>Total Pemasukan</th>
                <th>Total Pengeluaran</th>
                <th>Laba Bersih</th>
            </tr>
        </thead>
        <tbody>
            @foreach($financialReports as $report)
                <tr>
                    <td>{{ $report->month }}</td>
                    <td>{{ $report->year }}</td>
                    <td>Rp {{ number_format($report->total_income, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($report->total_expense, 0, ',', '.') }}</td>
                    <td>Rp {{ number_format($report->net_profit, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <form action="{{ route('admin.finance.report') }}" method="GET">
        <button type="submit" class="btn btn-primary">Perbarui Laporan</button>
    </form>
</div>
@endsection
