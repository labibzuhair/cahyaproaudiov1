@extends('layouts.admin.master.master')


@section('title', 'Edit Pesanan')

@section('content')
    <div class="container mt-5">
        <h1 class="mb-4">Edit Transaksi</h1>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order_name">Nama Pemesan</label>
                <input type="text" class="form-control" id="order_name" name="order_name"
                    value="{{ old('order_name', $transaction->order_name) }}" required>
            </div>
            <div class="form-group">
                <label for="order_whatsapp">No WhatsApp</label>
                <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp"
                    value="{{ old('order_whatsapp', $transaction->order_whatsapp) }}" required>
            </div>
            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select class="form-control" id="district_id" name="district_id" required>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ old('district_id', $transaction->district_id) == $district->id ? 'selected' : '' }}>
                            {{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
                <textarea class="form-control" id="installation_address" name="installation_address" required>{{ old('installation_address', $transaction->installation_address) }}</textarea>
            </div>

            <h3 class="mt-4">Produk yang Dipesan</h3>
            <div id="products">
                @foreach ($transaction->rentals as $index => $rental)
                    <div class="product-group mb-3">
                        <div class="form-group">
                            <label for="produk_id">Produk</label>
                            <select class="form-control" name="products[{{ $index }}][produk_id]" required>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}"
                                        {{ old('products.' . $index . '.produk_id', $rental->produk_id) == $produk->id ? 'selected' : '' }}>
                                        {{ $produk->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                @endforeach
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Tambah Produk</button>

            <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
            <div class="form-group">
                <label for="rental_date">Tanggal Rental</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date"
                    value="{{ old('rental_date', \Carbon\Carbon::parse($transaction->rentals->first()->rental_date)->format('Y-m-d')) }}"
                    required>
            </div>
            <div class="form-group">
                <label for="rental_days">Jumlah Hari Rental</label>
                <input type="number" class="form-control" id="rental_days" name="rental_days"
                    value="{{ old('rental_days', $transaction->rentals->first()->rental_days) }}" required
                    min="1">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="menunggu" {{ old('status', $transaction->status) == 'menunggu' ? 'selected' : '' }}>
                        Menunggu
                    </option>
                    <option value="disetujui"
                        {{ old('status', $transaction->status) == 'disetujui' ? 'selected' : '' }}>
                        Disetujui
                    </option>
                    <option value="ditolak" {{ old('status', $transaction->status) == 'ditolak' ? 'selected' : '' }}>
                        Ditolak
                    </option>
                    <option value="diproses" {{ old('status', $transaction->status) == 'diproses' ? 'selected' : '' }}>
                        Diproses
                    </option>
                    <option value="selesai" {{ old('status', $transaction->status) == 'selesai' ? 'selected' : '' }}>
                        Selesai
                    </option>
                    <option value="dibatalkan"
                        {{ old('status', $transaction->status) == 'dibatalkan' ? 'selected' : '' }}>
                        Dibatalkan
                    </option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <script>
        function addProduct() {
            const productGroupCount = document.querySelectorAll('.product-group').length;
            const newProductGroup = document.createElement('div');
            newProductGroup.classList.add('product-group', 'mb-3');
            newProductGroup.innerHTML = `
                <div class="form-group">
                    <label for="produk_id">Produk</label>
                    <select class="form-control" name="products[${productGroupCount}][produk_id]" required>
                        @foreach ($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->name }}</option>
                        @endforeach
                    </select>
                </div>
            `;
            document.getElementById('products').appendChild(newProductGroup);
        }
    </script>
@endsection
