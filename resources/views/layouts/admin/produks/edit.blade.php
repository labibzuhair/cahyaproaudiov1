@extends('layouts.admin.master.master')

@section('title', 'Edit Produk')

@section('content')
    <div class="container">
        <h1>Update Produk</h1>
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        <form action="{{ route('admin.produks.update', $produk->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="name">Nama Produk</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $produk->name }}" required>
                @error('name')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="description">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" required>{{ $produk->description }}</textarea>
                @error('description')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="price">Harga Sewa</label>
                <input type="number" class="form-control" id="price" name="price" value="{{ $produk->price }}"
                    required>
                @error('price')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="type">Type Produk</label>
                <select class="form-control" id="type" name="type" required>
                    <option value="sound" {{ $produk->type == 'sound' ? 'selected' : '' }}>Sound</option>
                    <option value="tenda" {{ $produk->type == 'tenda' ? 'selected' : '' }}>Tenda</option>
                    <option value="dekorasi" {{ $produk->type == 'dekorasi' ? 'selected' : '' }}>Dekorasi</option>
                </select>
                @error('type')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="stock">Jumlah Produk</label>
                <input type="number" class="form-control" id="stock" name="stock" value="{{ $produk->stock }}"
                    required>
                @error('stock')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="form-group">
                <label for="photo_main">Foto Utama</label>
                <input type="file" class="form-control" id="photo_main" name="photo_main"
                    onchange="previewPhoto(this, 'preview_main')">
                @error('photo_main')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_main" src="{{ asset('storage/' . $produk->photo_main) }}" class="img-thumbnail mt-2"
                    width="150" alt="{{ $produk->name }}">
            </div>
            <div class="form-group">
                <label for="photo_1">Foto 1</label>
                <input type="file" class="form-control" id="photo_1" name="photo_1"
                    onchange="previewPhoto(this, 'preview_1')">
                @error('photo_1')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_1" src="{{ $produk->photo_1 ? asset('storage/' . $produk->photo_1) : '#' }}"
                    class="img-thumbnail mt-2" width="150" alt="{{ $produk->name }}"
                    style="{{ $produk->photo_1 ? '' : 'display: none;' }}">
                @if ($produk->photo_1)
                    <button type="button" class="btn btn-danger btn-sm mt-2"
                        onclick="removePhoto('photo_1', 'preview_1')">Hapus
                        Foto</button>
                    <input type="hidden" id="remove_photo_1" name="remove_photo_1" value="0">
                @endif
            </div>
            <div class="form-group">
                <label for="photo_2">Foto 2</label>
                <input type="file" class="form-control" id="photo_2" name="photo_2"
                    onchange="previewPhoto(this, 'preview_2')">
                @error('photo_2')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_2" src="{{ $produk->photo_2 ? asset('storage/' . $produk->photo_2) : '#' }}"
                    class="img-thumbnail mt-2" width="150" alt="{{ $produk->name }}"
                    style="{{ $produk->photo_2 ? '' : 'display: none;' }}">
                @if ($produk->photo_2)
                    <button type="button" class="btn btn-danger btn-sm mt-2"
                        onclick="removePhoto('photo_2', 'preview_2')">Hapus
                        Foto</button>
                    <input type="hidden" id="remove_photo_2" name="remove_photo_2" value="0">
                @endif
            </div>
            <div class="form-group">
                <label for="photo_3">Foto 3</label>
                <input type="file" class="form-control" id="photo_3" name="photo_3"
                    onchange="previewPhoto(this, 'preview_3')">
                @error('photo_3')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_3" src="{{ $produk->photo_3 ? asset('storage/' . $produk->photo_3) : '#' }}"
                    class="img-thumbnail mt-2" width="150" alt="{{ $produk->name }}"
                    style="{{ $produk->photo_3 ? '' : 'display: none;' }}">
                @if ($produk->photo_3)
                    <button type="button" class="btn btn-danger btn-sm mt-2"
                        onclick="removePhoto('photo_3', 'preview_3')">Hapus
                        Foto</button>
                    <input type="hidden" id="remove_photo_3" name="remove_photo_3" value="0">
                @endif
            </div>
            <div class="form-group">
                <label for="photo_4">Foto 4</label>
                <input type="file" class="form-control" id="photo_4" name="photo_4"
                    onchange="previewPhoto(this, 'preview_4')">
                @error('photo_4')
                    <div class="text-danger">{{ $message }}</div>
                @enderror
                <img id="preview_4" src="{{ $produk->photo_4 ? asset('storage/' . $produk->photo_4) : '#' }}"
                    class="img-thumbnail mt-2" width="150" alt="{{ $produk->name }}"
                    style="{{ $produk->photo_4 ? '' : 'display: none;' }}">
                @if ($produk->photo_4)
                    <button type="button" class="btn btn-danger btn-sm mt-2"
                        onclick="removePhoto('photo_4', 'preview_4')">Hapus
                        Foto</button>
                    <input type="hidden" id="remove_photo_4" name="remove_photo_4" value="0">
                @endif
            </div>
            <button type="submit" class="btn btn-primary">Update Product</button>
        </form>
    </div>


@endsection
