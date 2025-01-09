<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Checkout</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Form Pemesanan</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <form id="orderForm" action="{{ route('orders.store') }}" method="POST">
            @csrf
            <div id="orderItems">
                @foreach ($cart as $item)
                    <div class="cart-item">
                        <h6>{{ $item['name'] }}</h6>
                        <p>Rp {{ number_format($item['price'], 0, ',', '.') }}</p>
                        <input type="hidden" name="products[{{ $loop->index }}][produk_id]"
                            value="{{ $item['id'] }}">
                        <input type="number" name="products[{{ $loop->index }}][quantity]" value="1"
                            min="1" class="form-control mb-2">
                    </div>
                @endforeach
            </div>
            <div class="form-group">
                <label for="order_name">Nama Pemesan</label>
                <input type="text" class="form-control" id="order_name" name="order_name" required>
            </div>
            <div class="form-group">
                <label for="order_whatsapp">No WhatsApp</label>
                <input type="text" class="form-control" id="order_whatsapp" name="order_whatsapp" required>
            </div>
            <div class="form-group">
                <label for="installation_address">Alamat Lengkap Pemasangan Alat</label>
                <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
            </div>
            <div class="form-group">
                <label for="rental_date">Tanggal Rental</label>
                <input type="date" class="form-control" id="rental_date" name="rental_date" required>
            </div>
            <div class="form-group">
                <label for="rental_days">Jumlah Hari Rental</label>
                <input type="number" class="form-control" id="rental_days" name="rental_days" required min="1">
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>
</body>

</html>
