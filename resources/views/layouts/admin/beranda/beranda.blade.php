@extends('layouts.admin.master.master')


@section('title', 'Halaman Utama')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
            {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                    class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
        </div>




        <!-- Content Row -->
        <div class="row">
            <!-- Pendapatan Bulanan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pendapatan (Bulan ini)</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($monthlyIncome, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-calendar fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Total Pendapatan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Total Pendapatan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($yearlyIncome, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-dollar-sign fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <!-- Pengeluaran Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pengeluaran</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($totalExpenses, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-outdent fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Current Balance Card -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-info shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                    Saldo Sekarang</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">
                                    Rp {{ number_format($currentBalance, 0, ',', '.') }}
                                </div>
                            </div>
                            <div class="col-auto">
                                <i class="fa-solid fa-scale-balanced fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Row -->

        <div class="row">

            <!-- Area Chart -->
            <div class="col-xl-8 col-lg-7">
                <div class="card shadow mb-4">
                    <!-- Card Header - Dropdown -->
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Ikhtisar Pendapatan</h6>
                        <div class="dropdown no-arrow">
                            <a class="dropdown-toggle" href="#" role="button" id="dropdownMenuLink"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-ellipsis-v fa-sm fa-fw text-gray-400"></i>
                            </a>
                            <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in"
                                aria-labelledby="dropdownMenuLink">
                                <div class="dropdown-header">Dropdown Header:</div>
                                <a class="dropdown-item" href="#">Action</a>
                                <a class="dropdown-item" href="#">Another action</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="#">Something else here</a>
                            </div>
                        </div>
                    </div>
                    <!-- Card Body -->
                    <div class="card-body">
                        <div class="chart-area">
                            <canvas id="myAreaChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <script>
                var labels = @json($keuangan->pluck('bulan'));
                var pemasukan = @json($keuangan->pluck('total_pemasukan'));
                var pengeluaran = @json($keuangan->pluck('total_pengeluaran'));
            </script>




<div class="col-xl-4 col-lg-5">
    <div class="card shadow mb-4">
        <!-- Card Header - Dropdown -->
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Projects</h6>
        </div>
        <div class="card-body" style="max-height: 400px; overflow-y: auto;">
            @foreach($produkPercentage as $produk)
                <h4 class="small font-weight-bold">{{ $produk->name }} <span class="float-right">{{ number_format($produk->order_percentage, 2) }}%</span></h4>
                <div class="progress mb-4" style="height: 20px;">
                    <div class="progress-bar {{ $produk->order_percentage <= 20 ? 'bg-danger' : ($produk->order_percentage <= 50 ? 'bg-warning' : ($produk->order_percentage <= 80 ? 'bg-info' : 'bg-success')) }}"
                        role="progressbar" style="width: {{ $produk->order_percentage }}%"
                        aria-valuenow="{{ $produk->order_percentage }}" aria-valuemin="0" aria-valuemax="100"></div>
                </div>
            @endforeach
        </div>
    </div>
</div>


        </div>


        <div class="row">
            <!-- Pesanan Menunggu -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-warning shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                    Pesanan Menunggu</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $pendingOrders }} Pesanan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-clock fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesanan Disetujui -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-success shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                    Pesanan Disetujui</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $approvedOrders }} Pesanan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesanan Dibatalkan -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-danger shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-danger text-uppercase mb-1">
                                    Pesanan Dibatalkan</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $canceledOrders }} Pesanan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-times-circle fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pesanan Selesai -->
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card border-left-primary shadow h-100 py-2">
                    <div class="card-body">
                        <div class="row no-gutters align-items-center">
                            <div class="col mr-2">
                                <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                    Pesanan Selesai</div>
                                <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $completedOrders }} Pesanan</div>
                            </div>
                            <div class="col-auto">
                                <i class="fas fa-check-double fa-2x text-gray-300"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <!-- Content Column -->
        <div class=" mb-4">

            <!-- Project Card Example -->
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Jadwal Rental</h6>
                </div>
                <section class="ftco-section">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="content">
                                    <div class="calendar-container">
                                        <div class="calendar">
                                            <div class="year-header">
                                                <span class="left-button fa fa-chevron-left" id="prev"> </span>
                                                <span class="year" id="label"></span>
                                                <span class="right-button fa fa-chevron-right" id="next"></span>
                                            </div>
                                            <table class="months-table w-100">
                                                <tbody>
                                                    <tr class="months-row">
                                                        <td class="month">Jan</td>
                                                        <td class="month">Feb</td>
                                                        <td class="month">Mar</td>
                                                        <td class="month">Apr</td>
                                                        <td class="month">May</td>
                                                        <td class="month">Jun</td>
                                                        <td class="month">Jul</td>
                                                        <td class="month">Aug</td>
                                                        <td class="month">Sep</td>
                                                        <td class="month">Oct</td>
                                                        <td class="month">Nov</td>
                                                        <td class="month">Dec</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table class="days-table w-100">
                                                <td class="day">Min</td>
                                                <td class="day">Sen</td>
                                                <td class="day">Sel</td>
                                                <td class="day">Rab</td>
                                                <td class="day">Kam</td>
                                                <td class="day">Jum</td>
                                                <td class="day">Sab</td>
                                            </table>
                                            <div class="frame">
                                                <table class="dates-table w-100">
                                                    <tbody class="tbody"></tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="events-container">

                                        <!-- Detail rentals akan ditampilkan di sini -->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>




    </div>
    <!-- End of Main Content -->


    {{--
 <div class="container mt-5">
                        <div id="calendar"></div>
                    </div>
<script>
document.addEventListener('DOMContentLoaded', function() {
    var calendarEl = document.getElementById('calendar');

    var calendar = new FullCalendar.Calendar(calendarEl, {
        initialView: 'dayGridMonth',
        events: [
            @foreach ($rentals as $rental)
            {
                title: '{{ $rental->transaction->user->name }} - {{ $rental->produk->name }}',
                start: '{{ $rental->rental_date }}',
                end: '{{ \Carbon\Carbon::parse($rental->return_date)->addDay()->format('Y-m-d') }}',
                backgroundColor: '{{ $rental->transaction->user->id % 2 == 0 ? '#28a745' : '#dc3545' }}',
                borderColor: '{{ $rental->transaction->user->id % 2 == 0 ? '#28a745' : '#dc3545' }}'
            },
            @endforeach
        ]
    });

    calendar.render();
});
</script> --}}


@endsection
