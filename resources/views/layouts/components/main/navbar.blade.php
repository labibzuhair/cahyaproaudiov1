    <!-- Navigation-->
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand" href="#page-top"><img src="{{ asset('assets/img/logo_cahya_pro_audio.png') }}"
                    alt="..." /></a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive"
                aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                Menu
                <i class="fas fa-bars ms-1"></i>
            </button>
            <div class="collapse navbar-collapse" id="navbarResponsive">
                <ul class="navbar-nav text-uppercase ms-auto py-4 py-lg-0">
                    <li class="nav-item"><a class="nav-link" href="#services">Pelayanan</a></li>
                    <li class="nav-item"><a class="nav-link" href="#portfolio">Produk</a></li>
                    <li class="nav-item"><a class="nav-link" href="#contact">Contact</a></li>
                    @auth
                        <li class="nav-item"><a class="nav-link" href="#about">Transaksi</a></li>
                        <li class="nav-item"><a class="nav-link" href="#team">History</a></li>
                        <a class="btn btn-primary" href="{{ url('logout') }}" role="button">Logout</a>
                    @else
                        <a class="btn btn-primary" href="{{ url('login') }}" role="button">Login</a>
                    @endauth
                    {{-- <li class="nav-item"><a class="nav-link" href="#about">Tentang Kami</a></li>
                    <li class="nav-item"><a class="nav-link" href="#team">Team</a></li> --}}
                </ul>
            </div>
        </div>
    </nav>
