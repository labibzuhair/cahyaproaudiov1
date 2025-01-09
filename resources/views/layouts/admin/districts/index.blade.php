@extends('layouts.admin.master.master')

@section('title', 'Semua Produk')

@section('content')

    <div class="container mt-5">
        <h1 class="mb-4">Kelola Kecamatan</h1>
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif
        <div class="row">
            <div class="col-md-6">
                <h3>Tambah Kecamatan Baru</h3>
                <form action="{{ route('admin.districts.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Kecamatan</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="form-group">
                        <label for="delivery_fee">Ongkir</label>
                        <input type="number" class="form-control" id="delivery_fee" name="delivery_fee" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </form>
            </div>
            <div class="col-md-6">
                <h3>Ubah Harga per Kecamatan</h3>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="search" placeholder="Cari Kecamatan...">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="button" id="reset-search">Reset</button>
                    </div>
                </div>
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nama Kecamatan</th>
                            <th>Ongkir</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="districts-table-body">
                        @foreach ($districts as $district)
                            <tr class="district-row">
                                <td class="district-name">{{ $district->name }}</td>
                                <td>{{ $district->delivery_fee }}</td>
                                <td>
                                    <form action="{{ route('admin.districts.update', $district->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <input type="number" class="form-control" name="delivery_fee"
                                            value="{{ $district->delivery_fee }}" required>
                                        <button type="submit" class="btn btn-success mt-2">Ubah</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('search').addEventListener('input', function() {
            let searchValue = this.value.toLowerCase();
            let districtRows = document.querySelectorAll('.district-row');

            districtRows.forEach(row => {
                let districtName = row.querySelector('.district-name').textContent.toLowerCase();
                if (districtName.includes(searchValue)) {
                    row.classList.remove('hidden');
                } else {
                    row.classList.add('hidden');
                }
            });
        });

        document.getElementById('reset-search').addEventListener('click', function() {
            document.getElementById('search').value = '';
            let districtRows = document.querySelectorAll('.district-row');
            districtRows.forEach(row => {
                row.classList.remove('hidden');
            });
        });
    </script>
@endsection
