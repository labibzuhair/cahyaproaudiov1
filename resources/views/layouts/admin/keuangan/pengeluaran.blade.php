@extends('layouts.admin')

@section('content')
<div class="container">
    <h1 class="mt-4">Tambah Pengeluaran</h1>

    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('admin.finance.expense') }}" method="POST">
        @csrf
        <div class="form-group">
            <label>Kategori</label>
            <input type="text" name="category" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Jumlah (Rp)</label>
            <input type="number" name="amount" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Tanggal</label>
            <input type="date" name="date" class="form-control" required>
        </div>
        <div class="form-group">
            <label>Deskripsi</label>
            <textarea name="description" class="form-control"></textarea>
        </div>
        <button type="submit" class="btn btn-danger">Simpan Pengeluaran</button>
    </form>
</div>
@endsection
