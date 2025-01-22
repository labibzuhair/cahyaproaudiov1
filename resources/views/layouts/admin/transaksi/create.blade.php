@extends('layouts.admin.master.master')


@section('title', 'Tambah Pesanan')

@section('content')

    <div class="container mt-5">
        <h1 class="mb-4">Form Pemesanan</h1>
        <form action="{{ route('admin.transactions.store') }}" method="POST">
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
            <div class="form-group"> <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
                <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
            </div>

            <h3 class="mt-4">Produk yang Dipesan</h3>
            <div id="products">
                <div class="product-group mb-3">
                    <div class="form-group">
                        <label for="produk_id">Produk</label>
                        <select class="form-control" name="products[0][produk_id]" required>
                            @foreach ($produks as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Tambah Produk</button>

            <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
            <div class="form-group">
                <label for="rental_date">Tanggal Rental</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date" required>
            </div>
            <div class="form-group">
                <label for="rental_days">Jumlah Hari Rental</label>
                <input type="number" class="form-control" id="rental_days" name="rental_days" required min="1">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="menunggu">Menunggu</option>
                    <option value="disetujui">Disetujui</option>
                    <option value="ditolak">Ditolak</option>
                    <option value="diproses">Diproses</option>
                    <option value="selesai">Selesai</option>
                    <option value="dibatalkan">Dibatalkan</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Tambah Pesanan</button>
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
