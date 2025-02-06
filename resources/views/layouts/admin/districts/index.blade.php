@extends('layouts.admin.master.master')

@section('title', 'Kecamatan')

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

                <section >
                    <div class="bg-image h-100" style="background-color: #f5f7fa;">
                      <div class="mask d-flex h-100">
                        <div class="container">
                          <div class="row justify-content-center">
                            <div class="">
                              <div class="card">
                                <div class="card-body p-0">
                                  <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 700px">
                                    <table class="table table-striped mb-0">
                                      <thead style="background-color: #002d72;">
                                        <tr>
                                          <th scope="col">Nama Kecamatan</th>
                                          <th scope="col">Ongkir</th>
                                          <th scope="col">Aksi</th>
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
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </section>

            </div>
        </div>
    </div>

@endsection
