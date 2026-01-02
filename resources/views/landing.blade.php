<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tel-Eat</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <style>
        /* --- TEMA WARNA ORANGE & PUTIH --- */
        :root {
            --primary-orange: #ff7e00;
            --dark-orange: #e66000;
            --soft-orange: #fff5e6;
        }

        body {
            font-family: 'Segoe UI', sans-serif;
            overflow-x: hidden;
        }

        /* Navbar Custom */
        .navbar-custom {
            background-color: white;
            padding: 15px 0;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .brand-text {
            color: var(--primary-orange);
            font-weight: 800;
            font-size: 1.5rem;
            letter-spacing: -1px;
        }

        /* Button Styles */
        .btn-orange {
            background-color: var(--primary-orange);
            color: white;
            border: none;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-orange:hover {
            background-color: var(--dark-orange);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(255, 126, 0, 0.3);
        }

        .btn-outline-dark-custom {
            border: 2px solid #333;
            color: #333;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 600;
            transition: 0.3s;
            text-decoration: none;
        }

        .btn-outline-dark-custom:hover {
            background-color: #333;
            color: white;
            transform: translateY(-2px);
        }

        /* Hero Section */
        .hero-section {
            background-color: var(--soft-orange);
            padding: 100px 0;
            position: relative;
        }

        .hero-title {
            font-weight: 800;
            color: #333;
            font-size: 3.5rem;
            line-height: 1.2;
        }

        .hero-title span {
            color: var(--primary-orange);
        }

        .hero-img {
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: rotate(-2deg);
            transition: 0.5s;
            border: 5px solid white;
        }

        .hero-img:hover {
            transform: rotate(0deg) scale(1.02);
        }

        /* Menu Card (Spoiler) */
        .menu-card {
            border: none;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.3s;
            background: white;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
            height: 100%;
        }

        .menu-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
        }

        .menu-img-wrapper {
            height: 200px;
            overflow: hidden;
            position: relative;
        }

        .menu-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: 0.5s;
        }

        .menu-card:hover .menu-img {
            transform: scale(1.1);
        }

        .menu-price {
            position: absolute;
            bottom: 10px;
            right: 10px;
            background: white;
            color: var(--primary-orange);
            padding: 5px 15px;
            border-radius: 20px;
            font-weight: bold;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        /* Fitur Section */
        .feature-card {
            background: white;
            padding: 30px;
            border-radius: 15px;
            border: 1px solid #eee;
            transition: 0.3s;
            height: 100%;
        }

        .feature-card:hover {
            border-color: var(--primary-orange);
            box-shadow: 0 10px 20px rgba(255, 126, 0, 0.1);
            transform: translateY(-5px);
        }

        .icon-box {
            width: 60px;
            height: 60px;
            background-color: var(--soft-orange);
            color: var(--primary-orange);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 20px;
        }

        /* Footer */
        footer {
            background-color: #333;
            color: white;
            padding: 50px 0;
            margin-top: 80px;
        }
    </style>
</head>

<body>

    @php
        // Atur Jam Buka & Tutup
        $jamBuka = '08:00';
        $jamTutup = '16:00';

        // Cek Waktu Sekarang (WIB)
        $now = \Carbon\Carbon::now('Asia/Jakarta');
        $startTime = \Carbon\Carbon::createFromTimeString($jamBuka, 'Asia/Jakarta');
        $endTime = \Carbon\Carbon::createFromTimeString($jamTutup, 'Asia/Jakarta');

        // Cek Status: Apakah sekarang di antara jam buka & tutup?
        $isOpen = $now->between($startTime, $endTime);
    @endphp

    <nav class="navbar navbar-expand-lg navbar-custom sticky-top">
        <div class="container">
            <a class="navbar-brand brand-text" href="#">
                <i class="bi bi-egg-fried"></i> Tel-Eat </a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-center gap-3">

                    <li class="nav-item">
                        <div class="d-flex align-items-center bg-light px-3 py-2 rounded-pill border">
                            <i class="bi bi-clock text-muted me-2"></i>
                            <div style="line-height: 1.2;">
                                <small class="d-block text-muted" style="font-size: 0.7rem;">JAM OPERASIONAL</small>
                                <span class="fw-bold text-dark" style="font-size: 0.85rem;">{{ $jamBuka }} -
                                    {{ $jamTutup }} WIB</span>
                            </div>
                        </div>
                    </li>

                    <li class="nav-item">
                        <div class="d-flex align-items-center px-3">
                            @if ($isOpen)
                                <span class="position-relative d-flex h-10 w-10 me-2">
                                    <span
                                        class="animate-ping position-absolute d-inline-flex h-100 w-100 rounded-circle bg-success opacity-75"></span>
                                    <span class="position-relative d-inline-flex rounded-circle bg-success"
                                        style="width: 10px; height: 10px;"></span>
                                </span>
                                <span class="fw-bold text-success small">Sedang Buka</span>
                            @else
                                <span class="position-relative d-flex h-10 w-10 me-2">
                                    <span class="position-relative d-inline-flex rounded-circle bg-danger"
                                        style="width: 10px; height: 10px;"></span>
                                </span>
                                <span class="fw-bold text-danger small">Sedang Tutup</span>
                            @endif
                        </div>
                    </li>

                </ul>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 mb-5 mb-md-0">
                    <span class="badge bg-warning text-dark mb-3 px-3 py-2 rounded-pill">Solusi Lapar Mahasiswa</span>
                    <h1 class="hero-title">Pesan Makan <br> Gak Pakai <span>Antri.</span></h1>
                    <p class="lead text-secondary mb-4">
                        Platform kantin digital modern. Pilih menumu, bayar online, dan ambil pesananmu saat sudah siap.
                    </p>
                    <div class="d-flex gap-3">
                        <a href="{{ route('login') }}" class="btn btn-orange btn-lg shadow-sm">
                            <i class="bi bi-box-arrow-in-right me-2"></i> Login Sekarang
                        </a>
                        <a href="#preview-menu" class="btn btn-outline-dark-custom btn-lg">
                            <i class="bi bi-book me-2"></i> Lihat Menu
                        </a>
                    </div>

                    <div class="mt-5 d-flex justify-content-start gap-5">

                        <div class="d-flex align-items-center">
                            <div class="bg-warning bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-egg-fried text-warning fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalProducts }}+</h4>
                                <small class="text-muted" style="font-size: 0.8rem;">Pilihan Menu</small>
                            </div>
                        </div>

                        <div class="d-flex align-items-center">
                            <div class="bg-success bg-opacity-10 p-2 rounded-circle me-3">
                                <i class="bi bi-receipt text-success fs-4"></i>
                            </div>
                            <div>
                                <h4 class="fw-bold mb-0 text-dark">{{ $totalOrders }}+</h4>
                                <small class="text-muted" style="font-size: 0.8rem;">Pesanan Selesai</small>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-6 text-center">
                    <img src="{{ asset('images/foto_kantin.png') }}" class="hero-img img-fluid w-75" alt="foto kantin">
                </div>
            </div>
        </div>
    </section>

    <section id="preview-menu" class="py-5 bg-white">
        <div class="container py-5">
            <div class="row align-items-end mb-5">
                <div class="col-md-8">
                    <h6 class="text-primary fw-bold text-uppercase ls-2"
                        style="color: var(--primary-orange) !important;">Mau Makan Apa?</h6>
                    <h2 class="fw-bold">Menu Favorit Anak Tel-U</h2>
                    <p class="text-muted">Intip dikit menu yang tersedia hari ini.</p>
                </div>
                <div class="col-md-4 text-md-end">
                    <a href="{{ route('katalog') }}" class="btn btn-outline-dark rounded-pill px-4">
                        Lihat Selengkapnya <i class="bi bi-arrow-right ms-2"></i>
                    </a>
                </div>
            </div>

            <div class="row g-4">
                @forelse($products as $product)
                    <div class="col-md-3 col-6">
                        <div class="menu-card">
                            <div class="menu-img-wrapper">
                                <img src="{{ asset('storage/' . $product->gambar) }}" class="menu-img"
                                    alt="{{ $product->nama_produk }}">
                                <div class="menu-price">Rp {{ number_format($product->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="p-3">
                                <h6 class="fw-bold mb-1 text-truncate">{{ $product->nama_produk }}</h6>
                                <small class="text-muted">{{ $product->kategori->nama_kategori ?? 'Umum' }}</small>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12 text-center py-5">
                        <div class="text-muted">Belum ada menu yang ditampilkan. Login untuk melihat katalog lengkap.
                        </div>
                    </div>
                @endforelse
            </div>

            <div class="d-block d-md-none text-center mt-4">
                <a href="{{ route('katalog') }}" class="btn btn-orange w-100">Lihat Semua Menu</a>
            </div>
        </div>
    </section>

    <section id="fitur" class="py-5" style="background-color: #fafafa;">
        <div class="container py-5">
            <div class="text-center mb-5">
                <h6 class="text-primary fw-bold text-uppercase ls-2" style="color: var(--primary-orange) !important;">
                    Kenapa Tel-Eat?</h6>
                <h2 class="fw-bold">Makan Enak, Kuliah Lancar</h2>
            </div>

            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box"><i class="bi bi-phone"></i></div>
                        <h4>Pesan dari Kelas</h4>
                        <p class="text-muted">Lagi dengerin dosen tapi perut bunyi? Pesan diem-diem lewat HP, pas
                            istirahat tinggal ambil.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box"><i class="bi bi-wallet2"></i></div>
                        <h4>Cashless Payment</h4>
                        <p class="text-muted">Gak perlu ribet cari uang pas. Bayar pakai QRIS atau saldo,
                            Sat-set langsung lunas.</p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="icon-box"><i class="bi bi-clock-history"></i></div>
                        <h4>Real-time Status</h4>
                        <p class="text-muted">Pantau status pesananmu: 'Sedang Disiapkan' atau 'Siap Diambil'. Gak
                            perlu antre panjang!.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <footer>
        <div class="container text-center">
            <h4 class="fw-bold mb-3">Tel-Eat</h4>
            <p class="text-white-50 mb-4">Project Tugas Besar Pengembangan Aplikasi Website.</p>
            <p class="small">&copy; 2025 Tel-Eat team's. All Rights Reserved.</p>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>
