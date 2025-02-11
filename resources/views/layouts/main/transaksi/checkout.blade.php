@extends('layouts.main.master.master')

@section('title', 'Checkout')

@section('content')
    <div class="container mt-5" style="padding-top: 70px">
        <h2 class="text-center">Form Pemesanan</h2>
        <form action="{{ route('customer.checkout.store') }}" method="POST" id="checkout-form">
            @csrf
            <div class="form-group">
                <label for="order_name">Nama Pemesan</label>
                <input type="text" class="form-control" id="order_name" name="order_name" required>
            </div>
            <div class="form-group">
                <label for="order_whatsapp">No WhatsApp</label>
                <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp" required>
            </div>
            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select class="form-control" id="district_id" name="district_id" required>
                    <option selected disabled>Pilih Kecamatan</option>


                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
            <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
        </div>

        <h3 class="mt-4">Produk yang Dipesan</h3>
        <div id="products">
            @foreach ($cartItems as $index => $item)
            <div class="product-group mb-3">
                <div class="form-group">
                    <label for="produk_id">Produk</label>
                    <input type="text" class="form-control" value="{{ $item->produk->name }}" readonly>
                    <input type="hidden" name="products[{{ $index }}][produk_id]"
                        value="{{ $item->produk_id }}">
                    <input type="hidden" name="products[{{ $index }}][quantity]"
                        value="{{ $item->quantity }}">
                </div>
            </div>
            @endforeach
        </div>


                    <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
                    <div class="form-group">
                        <label for="rental_date">Tanggal Rental</label>
                        <input type="text" class="form-control" id="rental_date" name="rental_date"
                            placeholder="Pilih Tanggal Pada Kalender di Bawah" required readonly>

                        <label for="rental_days">Jumlah Hari Rental</label>
                        <input type="number" class="form-control" id="rental_days" name="rental_days"
                            placeholder="Pilih Tanggal Pada Kalender di Bawah" required min="1">

                        <section class="ftco-section-small">
                            <div class="container">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="content content-small" id="create-calendar">
                                            <div class="small-calendar-container">
                                                <div class="calendar">
                                                    <div class="year-header">
                                                        <span class="left-button fa fa-chevron-left" style="margin-top: 13px;" id="prev"> </span>
                                                        <span class="year" id="label"></span>
                                                        <span class="right-button fa fa-chevron-right" style="margin-top: 13px;" id="next"></span>
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </section>
                    </div>


                    <!-- Pastikan variabel rentals tersedia di JavaScript -->
                    <script>
                        var rentals = @json($rentals);
                    </script>


        <button type="submit" class="btn btn-primary">Pesan</button>
    </form>
</div>
@endsection
