<div class="row flex-column">
    @foreach ($recommendedProduks as $produk)
        <div class="col-12 mb-3"> <!-- Gunakan col-12 agar satu produk satu baris -->
            <div class="card">
                <img src="{{ asset('storage/' . $produk->photo_main) }}" class="card-img-top" alt="{{ $produk->name }}">
                <div class="card-body">
                    <h5 class="card-title">{{ $produk->name }}</h5>
                    <p class="card-text">Rp {{ number_format($produk->price, 0, ',', '.') }}</p>
                    <form id="add-to-cart-form-{{ $produk->id }}"
                        action="{{ route('customer.cart.add', $produk->id) }}" method="POST">
                        @csrf
                        <button class="btn btn-primary btn-block add-to-cart-btn" type="button"
                            data-id="{{ $produk->id }}">Tambah ke Keranjang</button>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
</div>
