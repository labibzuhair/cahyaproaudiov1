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

// add keranjang
