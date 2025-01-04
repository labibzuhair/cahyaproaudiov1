<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <title>Form Pesanan</title>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Form Pesanan</h1>
        <form action="{{ route('transactions.store') }}" method="POST">
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
                <label for="installation_address">Alamat Pemasangan Alat</label>
                <textarea class="form-control" id="installation_address" name="installation_address" required></textarea>
            </div>
            
            <h3 class="mt-4">Produk yang Dipesan</h3>
            <div id="products">
                <div class="product-group mb-3">
                    <div class="form-group">
                        <label for="produk_id">Produk</label>
                        <select class="form-control" name="products[0][produk_id]" required>
                            @foreach($produks as $produk)
                                <option value="{{ $produk->id }}">{{ $produk->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Jumlah</label>
                        <input type="number" class="form-control" name="products[0][quantity]" required>
                    </div>
                </div>
            </div>
            <button type="button" class="btn btn-secondary mb-3" onclick="addProduct()">Tambah Produk</button>

            <div class="form-group">
                <label for="status">Status</label>
                <select class="form-control" id="status" name="status" required>
                    <option value="pending">Pending</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
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
                        @foreach($produks as $produk)
                            <option value="{{ $produk->id }}">{{ $produk->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="quantity">Jumlah</label>
                    <input type="number" class="form-control" name="products[${productGroupCount}][quantity]" required>
                </div>
            `;
            document.getElementById('products').appendChild(newProductGroup);
        }
    </script>
</body>
</html>