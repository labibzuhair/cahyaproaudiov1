<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Edit Transaksi</title>

</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Edit Transaksi</h1>
        <form action="{{ route('admin.transactions.update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="order_name">Nama Pemesan</label>
                <input type="text" class="form-control" id="order_name" name="order_name"
                    value="{{ $transaction->order_name }}" required>
            </div>
            <div class="form-group">
                <label for="order_whatsapp">No WhatsApp</label>
                <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp"
                    value="{{ $transaction->order_whatsapp }}" required>
            </div>
            <div class="form-group">
                <label for="district_id">Kecamatan</label>
                <select class="form-control" id="district_id" name="district_id" required>
                    @foreach ($districts as $district)
                        <option value="{{ $district->id }}"
                            {{ $district->id == $transaction->district_id ? 'selected' : '' }}>{{ $district->name }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="form-group">
                <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
                <textarea class="form-control" id="installation_address" name="installation_address" required>{{ $transaction->installation_address }}</textarea>
            </div>

            <h3 class="mt-4">Produk yang Dipesan</h3>
            <div id="products">
                @foreach ($transaction->rentals as $index => $rental)
                    <div class="product-group mb-3">
                        <div class="form-group"> <label for="produk_id">Produk</label> <select class="form-control"
                                name="products[{{ $index }}][produk_id]" required>
                                @foreach ($produks as $produk)
                                    <option value="{{ $produk->id }}"
                                        {{ $produk->id == $rental->produk_id ? 'selected' : '' }}>{{ $produk->name }}
                                    </option>
                                @endforeach
                            </select> </div>
                    </div>
                @endforeach
            </div> <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Tambah Produk</button>

            <!-- Input Tanggal Rental dan Jumlah Hari Rental -->
            <div class="form-group">
                <label for="rental_date">Tanggal Rental</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date"
                    value="{{ \Carbon\Carbon::parse($transaction->rentals->first()->rental_date)->format('Y-m-d') }}"
                    required>
            </div>
            <div class="form-group">
                <label for="rental_days">Jumlah Hari Rental</label>
                <input type="number" class="form-control" id="rental_days" name="rental_days"
                    value="{{ $transaction->rentals->first()->rental_days }}" required min="1">
            </div>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending" {{ $transaction->status == 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="completed" {{ $transaction->status == 'completed' ? 'selected' : '' }}>Completed
                    </option>
                    <option value="cancelled" {{ $transaction->status == 'cancelled' ? 'selected' : '' }}>Cancelled
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
            newProductGroup.innerHTML =
                ` <div class="form-group"> <label for="produk_id">Produk</label>
        <select class="form-control" name="products[${productGroupCount}][produk_id]" required>
            @foreach ($produks as $produk)
                <option value="{{ $produk->id }}">{{ $produk->name }}</option>
            @endforeach
        </select>
    </div> `;
            document.getElementById('products').appendChild(newProductGroup);
        }
    </script>
</body>

</html>
