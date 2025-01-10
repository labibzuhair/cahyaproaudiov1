<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>@yield('title', 'Beranda')</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/logo_cahya_pro_audio.png') }}" />
    <!-- Font Awesome icons (free version)-->
    <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
    <!-- Google fonts-->
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css" />
    <link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,100,300,700" rel="stylesheet" type="text/css" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="{{ asset('css/styles.css') }}" rel="stylesheet" />

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">

    <style>
        .added-to-cart {
            border: 2px solid green;
            /* Ganti dengan gaya yang diinginkan */
            background-color: #e8f5e9;
        }
    </style>




</head>

<body id="page-top">

    @include('layouts.components.main.navbar')


    <main class="container-fluid p-0">
        @yield('content')
    </main>
    @include('layouts.components.main.footer')



    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            function setupAddToCartButtons() {
                $('.add-to-cart-btn').off('click').on('click', function(e) {
                    e.preventDefault();

                    var produkId = $(this).data('id');
                    var form = $('#add-to-cart-form-' + produkId);
                    var url = form.attr('action');
                    var token = $('input[name=_token]', form).val();

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: token,
                            produk_id: produkId
                        },
                        success: function(response) {
                            var btn = $('#add-to-cart-form-' + produkId + ' .add-to-cart-btn');
                            btn.removeClass('btn-primary add-to-cart-btn').addClass(
                                'btn-danger remove-from-cart-btn').text(
                                'Hapus dari Keranjang');
                            btn.attr('data-id', produkId);
                            btn.off('click').on('click', function(e) {
                                e.preventDefault();
                                removeFromCart(produkId);
                            });

                            console.log(response.message);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            alert('Terjadi kesalahan, produk gagal ditambahkan ke keranjang.');
                        }
                    });
                });
            }

            function setupRemoveFromCartButtons() {
                $('.remove-from-cart-btn').off('click').on('click', function(e) {
                    e.preventDefault();

                    var produkId = $(this).data('id');
                    var form = $(this).closest('form');
                    var url = form.attr('action');
                    var token = $('input[name=_token]', form).val();

                    $.ajax({
                        url: url,
                        method: 'POST',
                        data: {
                            _token: token,
                        },
                        success: function(response) {
                            var btn = $('#add-to-cart-form-' + produkId +
                                ' .remove-from-cart-btn');
                            btn.removeClass('btn-danger remove-from-cart-btn').addClass(
                                'btn-primary add-to-cart-btn').text('Tambah ke Keranjang');
                            btn.attr('data-id', produkId);
                            btn.off('click').on('click', function(e) {
                                e.preventDefault();
                                addToCart(produkId);
                            });

                            if ($('#remove-from-cart-form-' + produkId).closest('tr').length) {
                                $('#remove-from-cart-form-' + produkId).closest('tr').remove();
                            }

                            console.log(response.message);
                        },
                        error: function(xhr) {
                            console.log(xhr.responseText);
                            alert('Terjadi kesalahan, produk gagal dihapus dari keranjang.');
                        }
                    });
                });
            }

            function addToCart(produkId) {
                var form = $('#add-to-cart-form-' + produkId);
                var url = form.attr('action');
                var token = $('input[name=_token]', form).val();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: token,
                        produk_id: produkId
                    },
                    success: function(response) {
                        var btn = $('#add-to-cart-form-' + produkId + ' .add-to-cart-btn');
                        btn.removeClass('btn-primary add-to-cart-btn').addClass(
                            'btn-danger remove-from-cart-btn').text('Hapus dari Keranjang');
                        btn.attr('data-id', produkId);
                        btn.off('click').on('click', function(e) {
                            e.preventDefault();
                            removeFromCart(produkId);
                        });

                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan, produk gagal ditambahkan ke keranjang.');
                    }
                });
            }

            function removeFromCart(produkId) {
                var form = $('#add-to-cart-form-' + produkId);
                var url = "{{ route('customer.cart.remove', '') }}/" + produkId;
                var token = $('input[name=_token]', form).val();

                $.ajax({
                    url: url,
                    method: 'POST',
                    data: {
                        _token: token,
                    },
                    success: function(response) {
                        var btn = $('#add-to-cart-form-' + produkId + ' .remove-from-cart-btn');
                        btn.removeClass('btn-danger remove-from-cart-btn').addClass(
                            'btn-primary add-to-cart-btn').text('Tambah ke Keranjang');
                        btn.attr('data-id', produkId);
                        btn.off('click').on('click', function(e) {
                            e.preventDefault();
                            addToCart(produkId);
                        });

                        if ($('#remove-from-cart-form-' + produkId).closest('tr').length) {
                            $('#remove-from-cart-form-' + produkId).closest('tr').remove();
                        }

                        console.log(response.message);
                    },
                    error: function(xhr) {
                        console.log(xhr.responseText);
                        alert('Terjadi kesalahan, produk gagal dihapus dari keranjang.');
                    }
                });
            }

            setupAddToCartButtons();
            setupRemoveFromCartButtons();
        });
    </script>









    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Bootstrap core JS-->
    <script src="{{ asset('bootstrap/js/bootstrap.bundle.min.js') }}"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Core theme JS-->
    <script src="{{ asset('js/scripts.js') }}"></script>
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <!-- * *                               SB Forms JS                               * *-->
    <!-- * * Activate your form at https://startbootstrap.com/solution/contact-forms * *-->
    <!-- * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *-->
    <script src="https://cdn.startbootstrap.com/sb-forms-latest.js"></script>
</body>

</html>
