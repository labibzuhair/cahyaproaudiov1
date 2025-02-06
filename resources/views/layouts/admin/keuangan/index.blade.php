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


    <div class="container mt-5" style="padding-top: 70px">
        <h2 class="mb-4">Laporan Keuangan</h2>
        <a href="{{ route('admin.keuangan.laporan') }}" class="btn btn-primary mb-3">
            <i class="fa-solid fa-rotate"></i> Refrash Laporan
        </a>
        <a href="{{ route('admin.keuangan.pengeluaran.create') }}" class="btn btn-primary mb-3">
            + Tambah Pengeluaran
        </a>
        <section class="intro">
            <div class="bg-image h-100" style="background-color: #f5f7fa;">
              <div class="mask d-flex align-items-center h-100">
                <div class="container">
                  <div class="row justify-content-center">
                    <div class="col-12">
                      <div class="card">
                        <div class="card-body p-0">
                          <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 600px">
                            <table class="table table-striped mb-0">
                              <thead style="background-color: #002d72; color: white;">
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
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </section>
    </div>
</div>
@endsection

