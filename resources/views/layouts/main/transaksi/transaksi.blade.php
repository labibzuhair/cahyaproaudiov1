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
                        <th>ID Transaksi</th>
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
                            <td>{{ $transaction->id }}</td>
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
        <section class="ftco-section">
            <div class="container">
              <div class="row justify-content-center">
                <div class="col-md-6 text-center mb-5">
                  <h2 class="heading-section">Customer Calendar</h2>
                </div>
              </div>
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
                          <td class="day">Sun</td>
                          <td class="day">Mon</td>
                          <td class="day">Tue</td>
                          <td class="day">Wed</td>
                          <td class="day">Thu</td>
                          <td class="day">Fri</td>
                          <td class="day">Sat</td>
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
@endsection
