@extends('layouts.main')

@section('title', 'Edit Menu')
@section('page-title', 'Edit Menu Kantin')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Edit Menu: {{ $product->nama_produk }}</h6>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('products.update', $product->id_produk) }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT') <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="name" class="form-control" value="{{ $product->nama_produk }}"
                                required>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id_kategori }}"
                                            {{ $product->id_kategori == $cat->id_kategori ? 'selected' : '' }}>
                                            {{ $cat->nama_kategori }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" value="{{ $product->harga }}"
                                    required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok</label>
                            <input type="number" name="stock" class="form-control" value="{{ $product->stok }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3">{{ $product->deskripsi }}</textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ganti Foto (Opsional)</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            @if ($product->gambar)
                                <small class="text-muted d-block mt-2">Foto saat ini:</small>
                                <img src="{{ asset('storage/' . $product->gambar) }}" width="100"
                                    class="rounded border mt-1">
                            @endif
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-orange px-4"><i class="bi bi-save me-2"></i> Update
                                Menu</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
