@extends('layouts.main')

@section('title', 'Tambah Menu')
@section('page-title', 'Tambah Menu Baru')

@section('content')
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white py-3">
                    <h6 class="mb-0 fw-bold">Form Input Menu</h6>
                </div>
                <div class="card-body p-4">

                    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Menu</label>
                            <input type="text" name="name" class="form-control" required
                                placeholder="Contoh: Ayam Geprek Sambal Ijo">
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kategori</label>
                                <select name="category_id" class="form-select" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    @foreach ($categories as $cat)
                                        <option value="{{ $cat->id_kategori }}">{{ $cat->nama_kategori }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Harga (Rp)</label>
                                <input type="number" name="price" class="form-control" required placeholder="15000">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Stok Awal</label>
                            <input type="number" name="stock" class="form-control" required value="20">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Deskripsi</label>
                            <textarea name="description" class="form-control" rows="3" placeholder="Deskripsi singkat menu..."></textarea>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto Menu</label>
                            <input type="file" name="image" class="form-control" accept="image/*">
                            <small class="text-muted">Format: JPG/PNG, Maks 2MB</small>
                        </div>

                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('products.index') }}" class="btn btn-light border">Batal</a>
                            <button type="submit" class="btn btn-orange px-4"><i class="bi bi-save me-2"></i> Simpan
                                Menu</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
@endsection
