<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Keranjang</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Keranjang Anda</h1>
        <div id="cartItems">
            <!-- Produk dalam keranjang akan muncul di sini -->
        </div>
        <a href="{{ route('cart.checkout') }}" class="btn btn-primary mt-3">Lanjut ke Pemesanan</a>
    </div>
</body>
</html>
