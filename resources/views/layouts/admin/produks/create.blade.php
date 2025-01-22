@extends('layouts.admin.master.master')

@section('title', 'Tambah Produk')

@section('content')
    <div class="container">
        <h1>Tambah Produk</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('admin.produks.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="name">Nama Paket</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" required>{{ old('description') }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga Sewa</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ old('price') }}"
                    placeholder="Harga Sewa Perhari" required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type Produk</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="">Select Type</option>
                    <option value="sound" {{ old('type') == 'sound' ? 'selected' : '' }}>Sound</option>
                    <option value="tenda" {{ old('type') == 'tenda' ? 'selected' : '' }}>Tenda</option>
                    <option value="dekorasi" {{ old('type') == 'dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                </select>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Jumlah Produk</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ old('stock') }}"
                    placeholder="Jumlah Produk Yang di Sewakan Dalam Paket ini" required>
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="photo_main">Foto Utama</label>
                <input type="file" class="form-control" id="photo_main" name="photo_main" required
                    onchange="previewPhoto(this, 'preview_main')">
                @error('photo_main')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_main" src="#" alt="Main Photo"
                    style="display: none; width: 150px; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="photo_1">Foto 1</label>
                <input type="file" class="form-control" id="photo_1" name="photo_1"
                    onchange="previewPhoto(this, 'preview_1')">
                @error('photo_1')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_1" src="#" alt="Photo 1" style="display: none; width: 150px; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="photo_2">Foto 2</label>
                <input type="file" class="form-control" id="photo_2" name="photo_2"
                    onchange="previewPhoto(this, 'preview_2')">
                @error('photo_2')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_2" src="#" alt="Photo 2" style="display: none; width: 150px; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="photo_3">Foto 3</label>
                <input type="file" class="form-control" id="photo_3" name="photo_3"
                    onchange="previewPhoto(this, 'preview_3')">
                @error('photo_3')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_3" src="#" alt="Photo 3" style="display: none; width: 150px; margin-top: 10px;">
            </div>
            <div class="form-group">
                <label for="photo_4">Foto 4</label>
                <input type="file" class="form-control" id="photo_4" name="photo_4"
                    onchange="previewPhoto(this, 'preview_4')">
                @error('photo_4')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_4" src="#" alt="Photo 4"
                    style="display: none; width: 150px; margin-top: 10px;">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Produk</button>
        </form>
    </div>

@endsection
