@extends('layouts.admin.master.master')

@section('title', 'Semua Produk')

@section('content')

    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>
        <p class="mb-4">DataTables is a third party plugin that is used to generate the demo table below.
            For more information about DataTables, please visit the <a target="_blank" href="https://datatables.net">official
                DataTables documentation</a>.</p>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <a class="btn btn-primary" href="{{ route('admin.produks.create') }}" role="button">Tambah Data</a>
                <div class="d-flex">
                    <input type="text" id="search" class="form-control" placeholder="Search" onkeyup="searchTable()">
                    <select id="filterType" class="form-control ml-2" onchange="filterTable()">
                        <option value="">Semua Produk</option>
                        <option value="sound">Sound</option>
                        <option value="tenda">Tenda</option>
                        <option value="dekorasi">Dekorasi</option>
                    </select>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Type</th>
                                <th>Stok</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Deskripsi</th>
                                <th>Harga</th>
                                <th>Type</th>
                                <th>Stok</th>
                                <th>Foto</th>
                                <th>Aksi</th>
                            </tr>
                        </tfoot>
                        <tbody id="productTable">
                            @foreach ($produks as $index => $produk)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $produk->name }}</td>
                                    <td>{{ $produk->description }}</td>
                                    <td>Rp {{ number_format($produk->price, 0, ',', '.') }}</td>
                                    <td>{{ $produk->type }}</td>
                                    <td>{{ $produk->stock }}</td>
                                    <td>
                                        <div class="foto-produk">
                                            <img src="{{ asset('storage/' . $produk->photo_main) }}" class="img-thumbnail"
                                                alt="{{ $produk->name }}">
                                            @if ($produk->photo_1)
                                                <img src="{{ asset('storage/' . $produk->photo_1) }}" class="img-thumbnail"
                                                    alt="{{ $produk->name }}">
                                            @endif
                                            @if ($produk->photo_2)
                                                <img src="{{ asset('storage/' . $produk->photo_2) }}" class="img-thumbnail"
                                                    alt="{{ $produk->name }}">
                                            @endif
                                            @if ($produk->photo_3)
                                                <img src="{{ asset('storage/' . $produk->photo_3) }}" class="img-thumbnail"
                                                    alt="{{ $produk->name }}">
                                            @endif
                                            @if ($produk->photo_4)
                                                <img src="{{ asset('storage/' . $produk->photo_4) }}" class="img-thumbnail"
                                                    alt="{{ $produk->name }}">
                                            @endif
                                        </div>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                            <a href="{{ route('admin.produks.edit', $produk->id) }}"
                                                class="btn btn-warning btn-sm">Update</a>

                                            <form action="{{ route('admin.produks.destroy', $produk->id) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm"
                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus produk ini?')">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
    <!-- /.container-fluid -->



@endsection
