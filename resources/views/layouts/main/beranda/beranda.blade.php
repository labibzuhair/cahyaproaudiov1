@extends('layouts.main.master.master')


@section('title', 'Halaman Utama')

@section('content')

    <!-- Masthead-->
    <header class="masthead">
        <div class="container">
            @auth
                @if (Auth::user()->is_role == 'customer')
                    <div class="masthead-subheading">Halo {{ $getRecord->name }}!! Selamat datang di Studio CAHYA PRO AUDIO
                        OFFICIAL</div>
                @else
                    <div class="masthead-subheading">Selamat datang di Studio CAHYA PRO AUDIO OFFICIAL</div>
                @endif
            @else
                <div class="masthead-subheading">Selamat datang di Studio CAHYA PRO AUDIO OFFICIAL</div>
            @endauth
            <div class="masthead-heading text-uppercase">Senang Bekerja Sama Dengan Anda!!</div>
            <a class="btn btn-primary btn-xl text-uppercase" href="#services">Pelayanan Kami</a>
        </div>


    </header>
    <!-- Services-->

    <section class="page-section" id="services">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Pelayanan</h2>
                <h3 class="section-subheading text-muted">"Kami berkomitmen untuk selalu memberikan pelayanan terbaik,
                    dengan sepenuh hati, untuk kepuasan dan kenyamanan Anda. Karena bagi kami, setiap pelanggan adalah
                    prioritas."</h3>
            </div>
            <div class="row text-center">
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-volume-high fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Sound</h4>
                    <p class="text-muted">Menikmati kualitas suara terbaik untuk setiap acara Anda! Kami menyediakan sistem
                        sound profesional yang siap memenuhi berbagai kebutuhan, mulai dari acara kecil hingga besar.
                        Pastikan pengalaman audio yang sempurna dengan layanan sewa sound kami yang handal.</p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-laptop fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Tenda</h4>
                    <p class="text-muted">Lindungi acara Anda dengan tenda berkualitas yang nyaman dan kokoh. Kami
                        menawarkan berbagai pilihan tenda, dari acara formal hingga santai, yang dapat disesuaikan dengan
                        tema dan kebutuhan Anda. Dengan layanan sewa tenda kami, acara Anda tetap terlindungi dengan gaya.
                    </p>
                </div>
                <div class="col-md-4">
                    <span class="fa-stack fa-4x">
                        <i class="fas fa-circle fa-stack-2x text-primary"></i>
                        <i class="fas fa-holly-berry fa-stack-1x fa-inverse"></i>
                    </span>
                    <h4 class="my-3">Dekorasi</h4>
                    <p class="text-muted">Ciptakan suasana yang tak terlupakan dengan dekorasi yang menawan. Kami
                        menyediakan berbagai pilihan dekorasi yang elegan dan kreatif, yang dapat disesuaikan dengan tema
                        acara Anda. Dari pernikahan hingga event spesial lainnya, kami hadir untuk memberikan sentuhan
                        estetika yang sempurna.</p>
                </div>
            </div>
        </div>
    </section>
    <!-- Portfolio Grid-->
    <section class="page-section bg-light" id="portfolio">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Produk</h2>
                <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
            <div class="container mt-5 mb-5">
                <!-- Search bar and filter -->
                <div class="container mt-5 mb-5"> <!-- Search bar and filter -->
                    <div class="row mb-3">
                        <div class="col-md-6"> <input type="text" id="search" class="form-control"
                                placeholder="Search produk..."> </div>
                        <div class="col-md-6"> <select id="filterType" class="form-select">
                                <option value="">Semua Produk</option>
                                @foreach ($types as $type)
                                    <option value="{{ $type }}">{{ $type }}</option>
                                @endforeach
                            </select> </div>
                    </div>
                    <div class="row g-1" id="productContainer">
                        @foreach ($produks as $produk)
                            <div class="col-md-4 product" data-type="{{ $produk->type }}" data-name="{{ $produk->name }}"
                                id="product-{{ $produk->id }}">
                                <div class="p-card">
                                    <div class="p-carousel">
                                        <div id="carousel-{{ $produk->id }}" class="carousel slide"
                                            data-bs-ride="carousel">
                                            <div class="carousel-inner">
                                                <div class="carousel-item active">
                                                    <img src="{{ asset('storage/' . $produk->photo_main) }}"
                                                        class="w-100 d-block" alt="{{ $produk->name }}">
                                                </div>
                                                @if ($produk->photo_1)
                                                    <div class="carousel-item">
                                                        <img src="{{ asset('storage/' . $produk->photo_1) }}"
                                                            class="w-100 d-block" alt="{{ $produk->name }}">
                                                    </div>
                                                @endif
                                                @if ($produk->photo_2)
                                                    <div class="carousel-item">
                                                        <img src="{{ asset('storage/' . $produk->photo_2) }}"
                                                            class="w-100 d-block" alt="{{ $produk->name }}">
                                                    </div>
                                                @endif
                                                @if ($produk->photo_3)
                                                    <div class="carousel-item">
                                                        <img src="{{ asset('storage/' . $produk->photo_3) }}"
                                                            class="w-100 d-block" alt="{{ $produk->name }}">
                                                    </div>
                                                @endif
                                                @if ($produk->photo_4)
                                                    <div class="carousel-item">
                                                        <img src="{{ asset('storage/' . $produk->photo_4) }}"
                                                            class="w-100 d-block" alt="{{ $produk->name }}">
                                                    </div>
                                                @endif
                                            </div>
                                            <button class="carousel-control-prev" type="button"
                                                data-bs-target="#carousel-{{ $produk->id }}" data-bs-slide="prev">
                                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Previous</span>
                                            </button>
                                            <button class="carousel-control-next" type="button"
                                                data-bs-target="#carousel-{{ $produk->id }}" data-bs-slide="next">
                                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                                <span class="visually-hidden">Next</span>
                                            </button>
                                            <div class="carousel-indicators">
                                                <button type="button" data-bs-target="#carousel-{{ $produk->id }}"
                                                    data-bs-slide-to="0" class="active" aria-current="true"></button>
                                                @if ($produk->photo_1)
                                                    <button type="button" data-bs-target="#carousel-{{ $produk->id }}"
                                                        data-bs-slide-to="1"></button>
                                                @endif
                                                @if ($produk->photo_2)
                                                    <button type="button" data-bs-target="#carousel-{{ $produk->id }}"
                                                        data-bs-slide-to="2"></button>
                                                @endif
                                                @if ($produk->photo_3)
                                                    <button type="button" data-bs-target="#carousel-{{ $produk->id }}"
                                                        data-bs-slide-to="3"></button>
                                                @endif
                                                @if ($produk->photo_4)
                                                    <button type="button" data-bs-target="#carousel-{{ $produk->id }}"
                                                        data-bs-slide-to="4"></button>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-details">
                                        <div class="d-flex justify-content-between align-items-center mx-2">
                                            <h5 class="text-white">{{ $produk->name }}</h5>
                                            <span>Rp {{ number_format($produk->price, 0, ',', '.') }}</span>
                                        </div>
                                        <div class="mx-2">
                                            <hr class="line">
                                        </div>
                                        <div class="d-flex justify-content-between mt-2 spec mx-2">
                                            <div class="d-flex flex-column align-items-center">
                                                <h6 class="mb-0">TYPE</h6>
                                                <span>{{ $produk->type }}</span>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <h6 class="mb-0">Jum</h6>
                                                <span>{{ $produk->stock }}</span>
                                            </div>
                                            <div class="d-flex flex-column align-items-center">
                                                <h6 class="mb-0">DES</h6>
                                                <span>{{ Str::limit($produk->description, 30, '...') }}</span>
                                            </div>
                                        </div>
                                        <div class="buy mt-3">
                                            @auth
                                                @if (in_array($produk->id, $cartItems))
                                                    <!-- Tombol Hapus dari Keranjang -->
                                                    <form id="add-to-cart-form-{{ $produk->id }}"
                                                        action="{{ route('customer.cart.remove', $produk->id) }}"
                                                        method="POST"> @csrf <button
                                                            class="btn btn-danger btn-block remove-from-cart-btn"
                                                            type="button" data-id="{{ $produk->id }}"
                                                            onclick="removeFromCart({{ $produk->id }})">Hapus dari
                                                            Keranjang</button> </form>
                                                @else
                                                    <!-- Tombol Tambah ke Keranjang -->
                                                    <form id="add-to-cart-form-{{ $produk->id }}"
                                                        action="{{ route('customer.cart.add', $produk->id) }}"
                                                        method="POST"> @csrf <button
                                                            class="btn btn-primary btn-block add-to-cart-btn" type="button"
                                                            data-id="{{ $produk->id }}"
                                                            onclick="addToCart({{ $produk->id }})">Tambah ke
                                                            Keranjang</button> </form>
                                                @endif

                                            @endauth
                                            <button class="btn btn-secondary btn-block" type="button"
                                                data-bs-toggle="modal"
                                                data-bs-target="#buyNowModal-{{ $produk->id }}">Lihat</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal Detail Produk -->
                            <div class="modal fade" id="buyNowModal-{{ $produk->id }}" data-bs-backdrop="static"
                                data-bs-keyboard="false" tabindex="-1" aria-labelledby="buyNowModalLabel"
                                aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header modal-bg">
                                            <button type="button" class="btn-close btn-close-white"
                                                data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6 text-center mt-2">
                                                    <img id="activeImage-{{ $produk->id }}"
                                                        src="{{ asset('storage/' . $produk->photo_main) }}"
                                                        width="300">
                                                    <div class="mt-3">
                                                        <div class="thumbnail active"
                                                            id="thumbnail-{{ $produk->id }}-main"
                                                            onclick="changeImage('{{ asset('storage/' . $produk->photo_main) }}', {{ $produk->id }}, 'main')">
                                                            <img src="{{ asset('storage/' . $produk->photo_main) }}"
                                                                width="50">
                                                            <div class="overlay"></div>
                                                        </div>
                                                        @if ($produk->photo_1)
                                                            <div class="thumbnail" id="thumbnail-{{ $produk->id }}-1"
                                                                onclick="changeImage('{{ asset('storage/' . $produk->photo_1) }}', {{ $produk->id }}, '1')">
                                                                <img src="{{ asset('storage/' . $produk->photo_1) }}"
                                                                    width="50">
                                                                <div class="overlay"></div>
                                                            </div>
                                                        @endif
                                                        @if ($produk->photo_2)
                                                            <div class="thumbnail" id="thumbnail-{{ $produk->id }}-2"
                                                                onclick="changeImage('{{ asset('storage/' . $produk->photo_2) }}', {{ $produk->id }}, '2')">
                                                                <img src="{{ asset('storage/' . $produk->photo_2) }}"
                                                                    width="50">
                                                                <div class="overlay"></div>
                                                            </div>
                                                        @endif
                                                        @if ($produk->photo_3)
                                                            <div class="thumbnail" id="thumbnail-{{ $produk->id }}-3"
                                                                onclick="changeImage('{{ asset('storage/' . $produk->photo_3) }}', {{ $produk->id }}, '3')">
                                                                <img src="{{ asset('storage/' . $produk->photo_3) }}"
                                                                    width="50">
                                                                <div class="overlay"></div>
                                                            </div>
                                                        @endif
                                                        @if ($produk->photo_4)
                                                            <div class="thumbnail" id="thumbnail-{{ $produk->id }}-4"
                                                                onclick="changeImage('{{ asset('storage/' . $produk->photo_4) }}', {{ $produk->id }}, '4')">
                                                                <img src="{{ asset('storage/' . $produk->photo_4) }}"
                                                                    width="50">
                                                                <div class="overlay"></div>
                                                            </div>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="text-white mt-5">
                                                        <h1 class="mb-0 text-white">{{ $produk->name }}</h1>
                                                        <span class="intro-1">Harga: Rp
                                                            {{ number_format($produk->price, 0, ',', '.') }}</span>
                                                        <div class="mt-4">
                                                            <span class="intro-2">Jumlah Unit: {{ $produk->stock }}</span>
                                                        </div>
                                                        <div class="mt-4">
                                                            <span class="intro-2">{{ $produk->description }}</span>
                                                        </div>
                                                        <div class="mt-4 mb-5">
                                                            @auth
                                                                @if (in_array($produk->id, $cartItems))
                                                                    <!-- Tombol Hapus dari Keranjang -->
                                                                    <form id="add-to-cart-form-{{ $produk->id }}"
                                                                        action="{{ route('customer.cart.remove', $produk->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button class="btn btn-danger remove-from-cart-btn"
                                                                            type="button" data-id="{{ $produk->id }}"
                                                                            onclick="removeFromCart({{ $produk->id }})">Hapus
                                                                            dari Keranjang</button>
                                                                    </form>
                                                                @else
                                                                    <!-- Tombol Tambah ke Keranjang -->
                                                                    <form id="add-to-cart-form-{{ $produk->id }}"
                                                                        action="{{ route('customer.cart.add', $produk->id) }}"
                                                                        method="POST">
                                                                        @csrf
                                                                        <button class="btn btn-primary add-to-cart-btn"
                                                                            type="button" data-id="{{ $produk->id }}"
                                                                            onclick="addToCart({{ $produk->id }})">Tambah
                                                                            ke Keranjang</button>
                                                                    </form>
                                                                @endif
                                                            @endauth
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
    </section>



    {{-- <!-- About-->
    <section class="page-section" id="about">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Tentang Kami</h2>
                <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
            <ul class="timeline">
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/1.jpg"
                            alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>2009-2011</h4>
                            <h4 class="subheading">Our Humble Beginnings</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut
                                voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero
                                unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/2.jpg"
                            alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>March 2011</h4>
                            <h4 class="subheading">An Agency is Born</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut
                                voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero
                                unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                        </div>
                    </div>
                </li>
                <li>
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/3.jpg"
                            alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>December 2015</h4>
                            <h4 class="subheading">Transition to Full Service</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut
                                voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero
                                unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image"><img class="rounded-circle img-fluid" src="assets/img/about/4.jpg"
                            alt="..." /></div>
                    <div class="timeline-panel">
                        <div class="timeline-heading">
                            <h4>July 2020</h4>
                            <h4 class="subheading">Phase Two Expansion</h4>
                        </div>
                        <div class="timeline-body">
                            <p class="text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Sunt ut
                                voluptatum eius sapiente, totam reiciendis temporibus qui quibusdam, recusandae sit vero
                                unde, sed, incidunt et ea quo dolore laudantium consectetur!</p>
                        </div>
                    </div>
                </li>
                <li class="timeline-inverted">
                    <div class="timeline-image">
                        <h4>
                            Be Part
                            <br />
                            Of Our
                            <br />
                            Story!
                        </h4>
                    </div>
                </li>
            </ul>
        </div>
    </section>
    <!-- Team-->
    <section class="page-section bg-light" id="team">
        <div class="container">
            <div class="text-center">
                <h2 class="section-heading text-uppercase">Our Amazing Team</h2>
                <h3 class="section-subheading text-muted">Lorem ipsum dolor sit amet consectetur.</h3>
            </div>
            <div class="row">
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/1.jpg" alt="..." />
                        <h4>Parveen Anand</h4>
                        <p class="text-muted">Lead Designer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Parveen Anand Twitter Profile"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Parveen Anand Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Parveen Anand LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/2.jpg" alt="..." />
                        <h4>Diana Petersen</h4>
                        <p class="text-muted">Lead Marketer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Twitter Profile"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Diana Petersen LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="team-member">
                        <img class="mx-auto rounded-circle" src="assets/img/team/3.jpg" alt="..." />
                        <h4>Larry Parker</h4>
                        <p class="text-muted">Lead Developer</p>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Larry Parker Twitter Profile"><i class="fab fa-twitter"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Larry Parker Facebook Profile"><i class="fab fa-facebook-f"></i></a>
                        <a class="btn btn-dark btn-social mx-2" href="#!"
                            aria-label="Larry Parker LinkedIn Profile"><i class="fab fa-linkedin-in"></i></a>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto text-center">
                    <p class="large text-muted">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aut eaque,
                        laboriosam veritatis, quos non quis ad perspiciatis, totam corporis ea, alias ut unde.</p>
                </div>
            </div>
        </div>
    </section> --}}


@endsection
