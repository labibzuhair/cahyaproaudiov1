<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('admin.beranda') }}">
        <div class="sidebar-brand-icon rotate-n-15">
            <i class="fas fa-laugh-wink"></i>
        </div>
        <div class="sidebar-brand-text mx-3">Admin <sup>2</sup></div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <!-- Nav Item - Dashboard -->
    <li class="nav-item {{ request()->is('admin/beranda') ? 'active' : '' }}">
        <a class="nav-link" href="{{ route('admin.beranda') }}">
            <i class="fas fa-fw fa-tachometer-alt"></i>
            <span>Dashboard</span></a>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">

    <!-- Heading -->
    <div class="sidebar-heading">
        Navigasi Admin
    </div>

    <!-- Nav Item - Tables -->
    <li class="nav-item {{ request()->is('admin/produks') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.produks.index') }}">
            <i class="fa-solid fa-boxes-stacked"></i>
            <span>Semua Produk</span></a>
    </li>
    <li class="nav-item {{ request()->is('admin/districts') ? 'active' : '' }}">
        <a class="nav-link " href="{{ route('admin.districts.index') }}">
            <i class="fa-solid fa-truck-fast"></i>
            <span>Transport</span></a>
    </li>

    <!-- Nav Item - Pages Collapse Menu -->
    <li class="nav-item {{ request()->is('admin/transactions*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo"
            aria-expanded="true" aria-controls="collapseTwo">
            <i class="fa-solid fa-handshake"></i>
            <span>Transaksi</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Semua Transaksi</h6>
                <a class="collapse-item {{ request()->is('admin/transactions/create') ? 'active' : '' }}" href="{{ route('admin.transactions.create') }}">Tambah Pesanan</a>
                <a class="collapse-item {{ request()->is('admin/transactions') ? 'active' : '' }}" href="{{ route('admin.transactions.index') }}">Semua Transaksi</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/menunggu') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'menunggu') }}">Transaksi Menunggu</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/diproses') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'diproses') }}">Transaksi Diproses</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/selesai') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'selesai') }}">Transaksi Selesai</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/dibatalkan') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'dibatalkan') }}">Transaksi Dibatalkan</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/disetujui') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'disetujui') }}">Transaksi Disetujui</a>
                <a class="collapse-item {{ request()->is('admin/transactions/byStatus/ditolak') ? 'active' : '' }}" href="{{ route('admin.transactions.byStatus', 'ditolak') }}">Transaksi Ditolak</a>

            </div>
        </div>
    </li>

    <li class="nav-item {{ request()->routeIs('admin.keuangan.*') ? 'active' : '' }}">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseKeuangan" aria-expanded="true" aria-controls="collapseKeuangan">
            <i class="fas fa-money-bill"></i>  <span>Keuangan</span>
        </a>
        <div id="collapseKeuangan" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <h6 class="collapse-header">Semua Keuangan</h6>
                <a class="collapse-item {{ request()->routeIs('admin.keuangan.index') ? 'active' : '' }}" href="{{ route('admin.keuangan.index') }}">Keuangan</a>
                <a class="collapse-item {{ request()->routeIs('admin.keuangan.pemasukan') ? 'active' : '' }}" href="{{ route('admin.keuangan.pemasukan') }}">Pemasukan</a>
                <a class="collapse-item {{ request()->routeIs('admin.keuangan.pengeluaran') ? 'active' : '' }}" href="{{ route('admin.keuangan.pengeluaran') }}">Pengeluaran</a>
                <a class="collapse-item {{ request()->routeIs('admin.keuangan.laporan') ? 'active' : '' }}" href="{{ route('admin.keuangan.laporan') }}">Laporan Keuangan</a>
            </div>
        </div>
    </li>

    <!-- Divider -->
    <hr class="sidebar-divider">



    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>



</ul>
<!-- End of Sidebar -->
