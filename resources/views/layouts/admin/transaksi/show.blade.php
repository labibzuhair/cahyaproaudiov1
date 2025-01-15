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
        {{-- <h1 class="mb-4">Detail Transaksi</h1>

        <div class="card mb-4">
            <div class="card-header">
                Detail Transaksi
            </div>
            <div class="card-body">
                <p><strong>ID Transaksi:</strong> {{ $transaction->id }}</p>
                <p><strong>Nama Pelanggan:</strong> {{ $transaction->user->name }}</p>
                <p><strong>Atas Nama Sewa:</strong> {{ $transaction->order_name }}</p>
                <p><strong>No WhatsApp:</strong> {{ $transaction->order_whatsapp }}</p>
                <p><strong>Status:</strong> {{ ucfirst($transaction->status) }}</p>
                <p><strong>Lokasi:</strong>
                    {{ $transaction->district ? $transaction->district->name : 'Tidak Diketahui' }}</p>
                <p><strong>Tanggal Transaksi:</strong> {{ $transaction->created_at->format('d-m-Y') }}</p>
                <p><strong>Total Amount:</strong> Rp {{ number_format($transaction->total_amount, 0, ',', '.') }}</p>
            </div>
        </div> --}}

        <div class="card">
            <div class="card-header">
                Perubahan yang Dilakukan oleh User
            </div>
            <div class="card-body">
                @if ($changes->isEmpty())
                    <p>Tidak ada perubahan yang dilakukan oleh user.</p>
                @else
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Field</th>
                                <th>Nilai Lama</th>
                                <th>Nilai Baru</th>
                                <th>Tanggal Perubahan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($changes as $change)
                                <tr>
                                    <td>{{ $change->field }}</td>
                                    <td>{{ $change->old_value }}</td>
                                    <td>{{ $change->new_value }}</td>
                                    <td>{{ $change->created_at->format('d-m-Y H:i:s') }}</td>

                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <div class="mt-4">
                        <form action="{{ route('admin.transactions.approve_all', $transaction->id) }}" method="POST"
                            style="display:inline;"> @csrf @method('POST') <button type="submit"
                                class="btn btn-success">Setujui Semua</button> </form>
                        <form action="{{ route('admin.transactions.reject_all', $transaction->id) }}" method="POST"
                            style="display:inline;"> @csrf @method('POST') <button type="submit"
                                class="btn btn-danger">Tolak Semua</button> </form>
                @endif
            </div>
        </div>
    </div>




    <div class="container mt-5">
        <h1 class="mb-4">Detail Transaksi</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Produk</th>
                    <th>Jumlah Hari Rental</th>
                    <th>Harga Per Hari</th>
                    <th>Total Harga</th>
                    <th>Ongkir</th>
                    <th>Lokasi</th>
                    <th>Tanggal Penyewaan</th>
                    <th>Tanggal Pengembalian</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($transaction->rentals as $rental)
                    <tr>
                        <td>{{ $rental->produk->name }}</td>
                        <td>{{ $rental->rental_days }}</td>
                        <td>Rp {{ number_format($rental->produk->price, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($rental->produk->price * $rental->rental_days, 0, ',', '.') }}</td>
                        <td>Rp {{ number_format($rental->delivery_fee, 0, ',', '.') }}</td>
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
