/*!
* Start Bootstrap - Agency v7.0.12 (https://startbootstrap.com/theme/agency)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-agency/blob/master/LICENSE)
*/
//
// Scripts
//

window.addEventListener('DOMContentLoaded', event => {

    // Navbar shrink function
    var navbarShrink = function () {
        const navbarCollapsible = document.body.querySelector('#mainNav');
        if (!navbarCollapsible) {
            return;
        }
        if (window.scrollY === 0) {
            navbarCollapsible.classList.remove('navbar-shrink')
        } else {
            navbarCollapsible.classList.add('navbar-shrink')
        }

    };

    // Shrink the navbar
    navbarShrink();

    // Shrink the navbar when page is scrolled
    document.addEventListener('scroll', navbarShrink);

    //  Activate Bootstrap scrollspy on the main nav element
    const mainNav = document.body.querySelector('#mainNav');
    if (mainNav) {
        new bootstrap.ScrollSpy(document.body, {
            target: '#mainNav',
            rootMargin: '0px 0px -40%',
        });
    };

    // Collapse responsive navbar when toggler is visible
    const navbarToggler = document.body.querySelector('.navbar-toggler');
    const responsiveNavItems = [].slice.call(
        document.querySelectorAll('#navbarResponsive .nav-link')
    );
    responsiveNavItems.map(function (responsiveNavItem) {
        responsiveNavItem.addEventListener('click', () => {
            if (window.getComputedStyle(navbarToggler).display !== 'none') {
                navbarToggler.click();
            }
        });
    });

});


// image modal
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


// add and delete card button in beranda
$(document).ready(function() {

    function updateCartAndRecommendations(response) {
        $('#cart-container').html(response.cartHtml);
        $('#recommendations-container').html(response.recommendationsHtml);

        // Setup ulang tombol untuk elemen baru
        setupAddToCartButtons();
        setupRemoveFromCartButtons();
    }

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
                    var btn = $('#add-to-cart-form-' + produkId +
                        ' .add-to-cart-btn');
                    btn.removeClass('btn-primary add-to-cart-btn').addClass(
                        'btn-danger remove-from-cart-btn').text(
                        'Hapus dari Keranjang');
                    btn.attr('data-id', produkId);
                    btn.off('click').on('click', function(e) {
                        e.preventDefault();
                        removeFromCart(produkId);
                    });

                    // Hanya perbarui jika berada di halaman keranjang
                    if ($('#cart-container').length > 0) {
                        updateCartAndRecommendations(response);
                    }

                    console.log(response.message);
                },
                error: function(xhr) {
                    console.log(
                        'Kesalahan saat menambahkan produk ke keranjang:',
                        xhr
                        .responseText);
                    alert(
                        'Terjadi kesalahan, produk gagal ditambahkan ke keranjang.'
                    );
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
                    btn.removeClass('btn-danger remove-from-cart-btn')
                        .addClass(
                            'btn-primary add-to-cart-btn').text(
                            'Tambah ke Keranjang');
                    btn.attr('data-id', produkId);
                    btn.off('click').on('click', function(e) {
                        e.preventDefault();
                        addToCart(produkId);
                    });

                    if ($('#remove-from-cart-form-' + produkId).closest(
                            'tr').length) {
                        $('#remove-from-cart-form-' + produkId).closest(
                            'tr').remove();
                    }

                    // Hanya perbarui jika berada di halaman keranjang
                    if ($('#cart-container').length > 0) {
                        updateCartAndRecommendations(response);
                    }

                    console.log(response.message);
                },
                error: function(xhr) {
                    console.log(
                        'Kesalahan saat menghapus produk dari keranjang:',
                        xhr
                        .responseText);
                    alert(
                        'Terjadi kesalahan, produk gagal dihapus dari keranjang.'
                    );
                }
            });
        });
    }

    function addToCart(produkId) {
        var form = $('#add-to-cart-form-' + produkId);
        var url = "{{ route('customer.cart.add', '') }}/" + produkId;
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
                console.log('Kesalahan saat menambahkan produk ke keranjang:', xhr
                    .responseText);
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
                console.log('Kesalahan saat menghapus produk dari keranjang:', xhr
                    .responseText);
                alert('Terjadi kesalahan, produk gagal dihapus dari keranjang.');
            }
        });
    }

    setupAddToCartButtons();
    setupRemoveFromCartButtons();
});
