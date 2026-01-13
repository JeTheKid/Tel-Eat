<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menu Tel-Eat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <style>
        /* Tambahan CSS sedikit biar rapi */
        .badge-habis {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            z-index: 10;
        }

        .img-grayscale {
            filter: grayscale(100%);
            /* Bikin gambar jadi hitam putih kalau habis */
        }
    </style>
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show shadow-sm border-0" role="alert">
                <i class="bi bi-exclamation-circle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark border-start border-4 border-warning ps-3">Lihat Menu Hari Ini</h3>
            <div class="dropdown">
                <button class="btn btn-light border dropdown-toggle rounded-pill px-4 shadow-sm" type="button"
                    data-bs-toggle="dropdown">
                    {{ request('kategori') ?? 'Semua Kategori' }}
                </button>
                <ul class="dropdown-menu shadow border-0">
                    <li><a class="dropdown-item" href="{{ route('katalog') }}">Semua Kategori</a></li>
                    @foreach ($categories as $cat)
                        <li>
                            <a class="dropdown-item {{ request('kategori') == $cat->nama_kategori ? 'active bg-orange' : '' }}"
                                href="{{ route('katalog', ['kategori' => $cat->nama_kategori]) }}">
                                {{ $cat->nama_kategori }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>

        <div class="row g-4">
            @forelse($products as $product)
                <div class="col-md-3 col-6">
                    <div class="card card-menu h-100">
                        <div class="card-img-wrapper position-relative">
                            <span class="category-badge">{{ $product->category->nama_kategori ?? 'Umum' }}</span>

                            @if ($product->stok <= 0)
                                <div class="badge-habis">HABIS</div>
                            @endif

                            @if ($product->gambar)
                                <img src="{{ asset('gambar/' . $product->gambar) }}"
                                    class="card-img-top {{ $product->stok <= 0 ? 'img-grayscale' : '' }}">
                            @else
                                <div
                                    class="d-flex align-items-center justify-content-center h-100 bg-light text-secondary">
                                    <i class="bi bi-image-fill fs-1 opacity-25"></i>
                                </div>
                            @endif
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h6 class="card-title fw-bold mb-1">{{ $product->nama_produk }}</h6>
                            <p class="card-text text-muted small text-truncate">{{ $product->deskripsi }}</p>

                            <div class="mb-2">
                                @if ($product->stok <= 0)
                                    <span class="badge bg-danger text-white" style="font-size: 0.7rem;">Stok
                                        Habis</span>
                                @elseif($product->stok < 5)
                                    <span class="badge bg-warning text-dark" style="font-size: 0.7rem;">Sisa:
                                        {{ $product->stok }}</span>
                                @else
                                    <small class="text-muted" style="font-size: 0.8rem;">Stok:
                                        {{ $product->stok }}</small>
                                @endif
                            </div>

                            <div class="mt-auto d-flex justify-content-between align-items-center pt-2">
                                <span class="price-tag">Rp {{ number_format($product->harga, 0, ',', '.') }}</span>

                                @if ($product->stok > 0)
                                    @auth
                                        <form action="{{ route('add_to_cart', $product->id_produk) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="btn-add shadow-sm text-decoration-none border-0">
                                                <i class="bi bi-plus-lg"></i>
                                            </button>
                                        </form>
                                    @else
                                        <a href="{{ route('login') }}" class="btn-add shadow-sm text-decoration-none">
                                            <i class="bi bi-plus-lg"></i>
                                        </a>
                                    @endauth
                                @else
                                    <button class="btn btn-secondary rounded-circle shadow-sm border-0" disabled
                                        style="width: 35px; height: 35px; display: flex; align-items: center; justify-content: center;">
                                        <i class="bi bi-x-lg"></i>
                                    </button>
                                @endif

                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="100"
                        class="mb-3 opacity-50">
                    <p class="text-muted">Yah, kantinnya lagi kosong nih.</p>
                </div>
            @endforelse
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
