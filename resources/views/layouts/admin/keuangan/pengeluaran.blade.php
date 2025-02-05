@extends('layouts.admin.master.master')

@section('title', 'Riwayat Pengeluaran')

@section('content')
<div class="container">
    <h2>Riwayat Pengeluaran</h2>

    <!-- Tombol Tambah Pengeluaran -->
    <a href="{{ route('admin.keuangan.pengeluaran.create') }}" class="btn btn-primary mb-3">
        + Tambah Pengeluaran
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Jumlah</th>
                <th>Kategori</th>
                <th>Keterangan</th>
                <th>Aksi</th>
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
                    <!-- Tombol Hapus -->
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
@endsection
