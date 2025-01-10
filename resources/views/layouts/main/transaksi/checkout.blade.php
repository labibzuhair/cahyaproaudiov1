@extends('layouts.main.master.master')


@section('title', 'Chackout Form')

@section('content')
    <form action="{{ route('checkout.store') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="order_name">Nama Pemesan</label>
            <input type="text" class="form-control" id="order_name" name="order_name" required>
        </div>
        <div class="form-group">
            <label for="order_whatsapp">WhatsApp</label>
            <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp" required>
        </div>
        <div class="form-group">
            <label for="district_id">Kecamatan</label>
            <select class="form-control" id="district_id" name="district_id" required>
                @foreach ($districts as $district)
                    <option value="{{ $district->id }}">{{ $district->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="installation_address">Alamat Pemasangan</label>
            <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
        </div>
        <div class="form-group">
            <label for="rental_date">Tanggal Rental</label>
            <input type="date" class="form-control" id="rental_date" name="rental_date" required>
        </div>
        <div class="form-group">
            <label for="rental_days">Jumlah Hari Rental</label>
            <input type="number" class="form-control" id="rental_days" name="rental_days" required>
        </div>
        <button type="submit" class="btn btn-primary">Konfirmasi dan Sewa</button>
    </form>

@endsection
