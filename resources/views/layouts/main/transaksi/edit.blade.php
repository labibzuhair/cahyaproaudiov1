@extends('layouts.main.master.master')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="container mt-5">
        <h2 class="mb-4">Edit Transaksi</h2>
        <form action="{{ route('customer.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
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
                    <option value="" disabled {{ old('district_id', $transaction->district_id) ? '' : 'selected' }}>
                        Pilih Kecamatan</option>
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

            <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
            <div class="form-group">
                <label for="rental_date">Tanggal Rental</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date"
                    value="{{ old('rental_date', \Carbon\Carbon::parse($transaction->rentals->first()->rental_date)->toDateString()) }}"
                    required>
            </div>
            <div class="form-group">
                <label for="rental_days">Jumlah Hari Rental</label>
                <input type="number" class="form-control" id="rental_days" name="rental_days"
                    value="{{ old('rental_days', $transaction->rentals->first()->rental_days) }}" required min="1">
            </div>

            <h3 class="mt-4">Produk yang Disewa</h3>
            <div id="checkout-products">
                @foreach ($transaction->rentals as $index => $rental)
                    <div class="product-group mb-3">
                        <div class="form-group">
                            <label for="products[{{ $index }}][produk_id]">Produk</label>
                            <input type="text" class="form-control" value="{{ $rental->produk->name }}" readonly>
                            <input type="hidden" name="products[{{ $index }}][produk_id]"
                                value="{{ $rental->produk_id }}">
                        </div>
                        <button type="button" class="btn btn-danger remove-checkout-product-btn">Hapus</button>
                    </div>
                @endforeach
            </div>

            <h3 class="mt-4">Produk Lain</h3>
            <div id="other-products">
                @foreach ($produks as $produk)
                    <div class="other-product-group mb-3">
                        <div class="form-group">
                            <label>{{ $produk->name }}</label>
                            <input type="hidden" name="other_products[{{ $produk->id }}][produk_id]"
                                value="{{ $produk->id }}">
                            <button type="button" class="btn btn-primary add-checkout-product-btn">Tambah ke
                                Checkout</button>
                        </div>
                    </div>
                @endforeach
            </div>

            <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
        </form>
        <a href="{{ route('customer.transactions.index') }}" class="btn btn-secondary mt-3">Batal</a>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target && e.target.classList.contains('remove-checkout-product-btn')) {
                const productId = e.target.closest('.product-group').querySelector('input[name*="[produk_id]"]')
                    .value;
                const productName = e.target.closest('.product-group').querySelector('input[type="text"]').value;

                // Tambahkan kembali produk ke daftar produk lain
                const otherProductsContainer = document.getElementById('other-products');
                const newOtherProductGroup = document.createElement('div');
                newOtherProductGroup.classList.add('other-product-group', 'mb-3');
                newOtherProductGroup.innerHTML = `
                    <div class="form-group">
                        <label>${productName}</label>
                        <input type="hidden" name="other_products[${productId}][produk_id]" value="${productId}">
                        <button type="button" class="btn btn-primary add-checkout-product-btn">Tambah ke Checkout</button>
                    </div>
                `;
                otherProductsContainer.appendChild(newOtherProductGroup);

                e.target.closest('.product-group').remove();
            } else if (e.target && e.target.classList.contains('add-checkout-product-btn')) {
                const otherProductGroup = e.target.closest('.other-product-group');
                const produkId = otherProductGroup.querySelector('input[name*="[produk_id]"]').value;
                const produkName = otherProductGroup.querySelector('label').textContent;
                const productGroupCount = document.querySelectorAll('.product-group').length;
                const newProductGroup = document.createElement('div');
                newProductGroup.classList.add('product-group', 'mb-3');
                newProductGroup.innerHTML = `
                    <div class="form-group">
                        <label for="products[${productGroupCount}][produk_id]">Produk</label>
                        <input type="hidden" name="products[${productGroupCount}][produk_id]" value="${produkId}">
                        <input type="text" class="form-control" value="${produkName}" readonly>
                    </div>
                    <button type="button" class="btn btn-danger remove-checkout-product-btn">Hapus</button>
                `;
                document.getElementById('checkout-products').appendChild(newProductGroup);
                otherProductGroup.remove();
            }
        });
    </script>
@endsection
