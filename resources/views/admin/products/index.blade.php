@extends('layouts.sidebar')

@section('title', 'Kelola Menu')
@section('page-title', 'Daftar Menu')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h4 class="fw-bold mb-1 text-dark">Daftar Makanan & Minuman</h4>
            <p class="text-muted small mb-0">Kelola stok, harga, dan varian menu di sini.</p>
        </div>
        <a href="{{ route('products.create') }}" class="btn btn-orange rounded-pill px-4 fw-bold shadow-sm">
            <i class="bi bi-plus-lg me-1"></i> Tambah Menu
        </a>
    </div>

    @if (session('success'))
        <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">Produk</th>
                        <th class="text-secondary text-uppercase small fw-bold">Kategori</th>
                        <th class="text-secondary text-uppercase small fw-bold">Harga</th>
                        <th class="text-secondary text-uppercase small fw-bold">Stok</th>
                        <th class="text-secondary text-uppercase small fw-bold">Status</th>
                        <th class="text-secondary text-uppercase small fw-bold text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($products as $product)
                        <tr>
                            <td class="ps-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-3">
                                        @if ($product->gambar)
                                            <img src="{{ asset('gambar/' . $product->gambar) }}"
                                                class="rounded-3 shadow-sm object-fit-cover border" width="60"
                                                height="60">
                                        @else
                                            <div class="bg-light rounded-3 d-flex align-items-center justify-content-center border"
                                                style="width: 60px; height: 60px;">
                                                <i class="bi bi-image text-muted opacity-50"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $product->nama_produk }}</div>
                                        <small class="text-muted d-block text-truncate" style="max-width: 150px;">
                                            {{ $product->deskripsi ?? 'Tidak ada deskripsi' }}
                                        </small>
                                    </div>
                                </div>
                            </td>

                            <td>
                                <span class="badge bg-light text-dark border fw-normal px-3 py-2 rounded-pill">
                                    {{ $product->category->nama_kategori ?? 'Uncategorized' }}
                                </span>
                            </td>

                            <td class="fw-bold text-orange">
                                Rp {{ number_format($product->harga, 0, ',', '.') }}
                            </td>

                            <td>
                                @if ($product->stok <= 5)
                                    <span class="badge bg-danger bg-opacity-10 text-danger px-2 py-1">
                                        <i class="bi bi-exclamation-circle me-1"></i> Sisa {{ $product->stok }}
                                    </span>
                                @else
                                    <span class="fw-bold text-dark">{{ $product->stok }}</span> <small
                                        class="text-muted">porsi</small>
                                @endif
                            </td>

                            <td>
                                @if ($product->status == 'aktif')
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Diarsipkan</span>
                                @endif
                            </td>

                            <td class="text-end pe-4">
                                <a href="{{ route('products.edit', $product->id_produk) }}"
                                    class="btn btn-sm btn-warning me-1">
                                    <i class="bi bi-pencil"></i>
                                </a>

                                @if ($product->status == 'aktif')
                                    <form action="{{ route('products.destroy', $product->id_produk) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger"
                                            onclick="return confirm('Apakah Anda yakin? Jika menu belum pernah terjual, akan dihapus permanen.')">
                                            <i class="bi bi-eye-slash"></i> Arsip
                                        </button>
                                    </form>
                                @else
                                    <form action="{{ route('products.destroy', $product->id_produk) }}" method="POST"
                                        class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-success"
                                            onclick="return confirm('Tampilkan menu ini lagi?')">
                                            <i class="bi bi-eye"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-clipboard-x text-muted opacity-25" style="font-size: 4rem;"></i>
                                    <p class="fw-bold text-muted mt-3 mb-1">Belum ada menu tersimpan</p>
                                    <p class="text-secondary small mb-3">Yuk mulai tambahkan menu makanan sekarang!</p>
                                    <a href="{{ route('products.create') }}"
                                        class="btn btn-sm btn-orange rounded-pill px-4">
                                        Buat Menu Pertama
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
