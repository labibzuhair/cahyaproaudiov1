@extends('layouts.admin.master.master')

@section('title', 'Tambah Pengeluaran')

@section('content')
<div class="container">
    <h2>Tambah Pengeluaran</h2>

    <form action="{{ route('admin.keuangan.pengeluaran.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="category" class="form-label" style="color: black;">Kategori</label>
            <input type="text" class="form-control" id="category" name="category" required>
        </div>
        <div class="mb-3">
            <label for="amount" class="form-label" style="color: black;">Jumlah Pengeluaran</label>
            <input type="number" class="form-control" id="amount" name="amount" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label" style="color: black;">Keterangan</label>
            <textarea class="form-control" id="description" name="description" rows="3"></textarea>
        </div>
        <div class="mb-3">
            <label for="date" class="form-label" style="color: black;">Tanggal</label>
            <input type="date" class="form-control" id="date" name="date" required>
        </div>
        <button type="submit" class="btn btn-success">Simpan</button>
        <a href="{{ route('admin.keuangan.pengeluaran') }}" class="btn btn-secondary">Batal</a>
    </form>
</div>
@endsection
