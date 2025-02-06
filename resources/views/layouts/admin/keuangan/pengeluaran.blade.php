@extends('layouts.admin.master.master')

@section('title', 'Riwayat Pengeluaran')

@section('content')
<section class="intro">
  <div class="bg-image h-100" style="background-color: #f5f7fa;">
    <div class="mask d-flex align-items-center h-100">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12">
            <div class="card">
              <div class="card-body p-4">
                <h2 class="text-center mb-4">Riwayat Pengeluaran</h2>

                <!-- Tombol Tambah Pengeluaran -->
                <a href="{{ route('admin.keuangan.pengeluaran.create') }}" class="btn btn-primary mb-3">
                  + Tambah Pengeluaran
                </a>

                <div class="table-responsive table-scroll" data-mdb-perfect-scrollbar="true" style="position: relative; height: 600px">
                  <table class="table table-striped mb-0">
                    <thead style="background-color: #002d72; color: white;">
                      <tr>
                        <th scope="col">Tanggal</th>
                        <th scope="col">Jumlah</th>
                        <th scope="col">Kategori</th>
                        <th scope="col">Keterangan</th>
                        <th scope="col">Aksi</th>
                      </tr>
                    </thead>
                    <tbody>
                      @foreach ($expenses as $expense)
                      <tr>
                        <td>{{ $expense->date }}</td>
                        <td>Rp {{ number_format($expense->amount, 0, ',', '.') }}</td>
                        <td>{{ $expense->category }}</td>
                        <td>{{ $expense->description }}</td>
                        <td>
                          <form action="{{ route('admin.keuangan.pengeluaran.destroy', $expense->id) }}" method="POST"
                                onsubmit="return confirm('Apakah Anda yakin ingin menghapus pengeluaran ini?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
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
@endsection
