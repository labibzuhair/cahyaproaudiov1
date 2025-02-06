<table class="table table-bordered">
    <thead>
        <tr>
            <th  style="color: black;">Produk</th>
            <th  style="color: black;">Nama Produk</th>
            <th  style="color: black;">Harga</th>
            <th  style="color: black;">Jumlah</th>
            <th  style="color: black;">Total</th>
            <th  style="color: black;">Aksi</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($cartItems as $item)
            <tr>
                <td><img src="{{ asset('storage/' . $item->produk->photo_main) }}" width="100"
                        alt="{{ $item->produk->name }}"></td>
                <td>{{ $item->produk->name }}</td>
                <td>Rp {{ number_format($item->produk->price, 0, ',', '.') }}</td>
                <td>{{ $item->quantity }}</td>
                <td>Rp {{ number_format($item->produk->price * $item->quantity, 0, ',', '.') }}</td>
                <td>
                    <form id="remove-from-cart-form-{{ $item->produk_id }}"
                        action="{{ route('customer.cart.remove', $item->produk_id) }}" method="POST">
                        @csrf
                        <button type="button" class="btn btn-danger remove-from-cart-btn dell"
                            data-id="{{ $item->produk_id }}">Hapus</button>
                    </form>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
<div class="text-right">
    <a href="{{ route('customer.checkout.create') }}" class="btn btn-primary">Checkout</a>
</div>
