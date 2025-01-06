<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Detail Transaksi</title>
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Detail Transaksi</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah</th>
                    <th>Harga</th>
                    <th>Lokasi</th>
                    <th>Tanggal Penyewaan</th>
                    <th>Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->rentals as $rental)
                    <tr>
                        <td>{{ $rental->produk->name }}</td>
                        <td>{{ $rental->quantity }}</td>
                        <td>Rp {{ number_format($rental->price, 0, ',', '.') }}</td>
                        <td>{{ $rental->location }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->rental_date)->format('d-m-Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($rental->return_date)->format('d-m-Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <a href="{{ route('admin.transactions.index') }}" class="btn btn-primary">Kembali</a>
    </div>
</body>

</html>
