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




</head>

<body id="page-top">

    @include('layouts.components.main.navbar')


    <main class="container-fluid p-0">
        @yield('content')
    </main>
    @include('layouts.components.main.footer')


    <script>
        function changeImage(src, id) {
            document.getElementById('main-image-' + id).src = src;
            var thumbnails = document.querySelectorAll('#buyNowModal-' + id + ' .thumbnail');
            thumbnails.forEach(function(thumbnail) {
                thumbnail.classList.remove('active');
            });
            event.target.classList.add('active');
        }


        function changeImage(src, id, photoId) {
        document.getElementById('activeImage-' + id).src = src;

        // Hapus kelas 'active' dari semua thumbnail
        var thumbnails = document.querySelectorAll('#buyNowModal-' + id + ' .thumbnail');
        thumbnails.forEach(function(thumbnail) {
            thumbnail.classList.remove('active');
        });

        // Tambahkan kelas 'active' pada thumbnail yang diklik
        document.getElementById('thumbnail-' + id + '-' + photoId).classList.add('active');
    }

    // search and filter produk branda
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('search');
        const filterType = document.getElementById('filterType');
        const productContainer = document.getElementById('productContainer');
        const products = Array.from(productContainer.getElementsByClassName('product'));

        searchInput.addEventListener('input', function() {
            filterProducts();
        });

        filterType.addEventListener('change', function() {
            filterProducts();
        });

        function filterProducts() {
            const searchValue = searchInput.value.toLowerCase();
            const typeValue = filterType.value;

            products.forEach(function(product) {
                const name = product.getAttribute('data-name').toLowerCase();
                const type = product.getAttribute('data-type');

                const matchesSearch = name.includes(searchValue);
                const matchesType = !typeValue || type === typeValue;

                if (matchesSearch && matchesType) {
                    product.style.display = '';
                } else {
                    product.style.display = 'none';
                }
            });
        }
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