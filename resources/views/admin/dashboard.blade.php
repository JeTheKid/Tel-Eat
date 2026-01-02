@extends('layouts.main')
@section('title', 'Dashboard')
@section('page-title', 'Overview')

@section('content')

    <div class="card border-0 shadow rounded-4 mb-4 overflow-hidden text-white"
        style="background: linear-gradient(45deg, #ff7e00, #ffb347);">
        <div class="card-body p-4 position-relative">

            <div class="position-absolute top-0 end-0 opacity-25 translate-middle-y me-n5 mt-n5"
                style="width: 200px; height: 200px; background: white; border-radius: 50%;"></div>
            <div class="position-absolute bottom-0 start-0 opacity-25 translate-middle-x ms-n5 mb-n5"
                style="width: 150px; height: 150px; background: white; border-radius: 50%;"></div>

            <div class="d-flex align-items-center justify-content-between position-relative z-1">
                <div>
                    <h3 class="fw-bold mb-1">Hi, {{ Auth::user()->nama ?? 'Admin' }}! 👋</h3>
                    <p class="mb-0 opacity-90">Kantin siap beroperasi. Semangat kerjanya!</p>
                </div>
                <div class="d-none d-md-block">
                    <a href="{{ route('products.create') }}"
                        class="btn btn-white text-orange fw-bold rounded-pill px-4 shadow-sm bg-white">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Menu
                    </a>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-white"
                style="background: linear-gradient(45deg, #4facfe, #00f2fe);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase small fw-bold opacity-75 mb-1">Total Pesanan</div>
                            <div class="h2 fw-bold mb-0">{{ $totalPesanan }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-bag-check-fill"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-white"
                style="background: linear-gradient(45deg, #43e97b, #38f9d7);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase small fw-bold opacity-75 mb-1">Pendapatan</div>
                            <div class="h2 fw-bold mb-0">Rp {{ number_format($pendapatanHariIni, 0, ',', '.') }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-wallet2"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-0 shadow-sm rounded-4 h-100 text-white"
                style="background: linear-gradient(45deg, #fa709a, #fee140);">
                <div class="card-body p-3">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <div class="text-uppercase small fw-bold opacity-75 mb-1">Menu Aktif</div>
                            <div class="h2 fw-bold mb-0">{{ $totalMenu }}</div>
                        </div>
                        <div class="fs-1 opacity-50">
                            <i class="bi bi-egg-fried"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm rounded-4">
        <div class="card-header bg-white py-3 border-bottom d-flex justify-content-between align-items-center">
            <h6 class="m-0 fw-bold text-dark"><i class="bi bi-clock-history me-2 text-orange"></i>Transaksi Terbaru</h6>
            <a href="{{ route('admin.orders.index') }}" class="small fw-bold text-decoration-none text-orange">Lihat Semua
                &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle mb-0">
                <thead class="bg-light">
                    <tr>
                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">ID</th>
                        <th class="text-secondary text-uppercase small fw-bold">Pelanggan</th>
                        <th class="text-secondary text-uppercase small fw-bold">Menu</th>
                        <th class="text-secondary text-uppercase small fw-bold">Total</th>
                        <th class="text-secondary text-uppercase small fw-bold">Status</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentOrders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-orange">#{{ $order->id_order }}</td>
                            <td>
                                <div class="fw-bold text-dark">{{ $order->user->nama ?? 'User Hilang' }}</div>
                                <small class="text-muted"
                                    style="font-size: 0.75rem;">{{ $order->created_at->diffForHumans() }}</small>
                            </td>
                            <td>
                                {{ $order->details->first()->product->nama_produk ?? '-' }}
                                @if ($order->details->count() > 1)
                                    <small class="text-muted ms-1">(+{{ $order->details->count() - 1 }} lain)</small>
                                @endif
                            </td>
                            <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}</td>
                            <td>
                                @php
                                    $badges = [
                                        'menunggu_konfirmasi' => 'bg-warning text-dark',
                                        'diproses' => 'bg-info text-white',
                                        'selesai' => 'bg-success text-white',
                                        'batal' => 'bg-danger text-white',
                                    ];
                                @endphp
                                <span class="badge {{ $badges[$order->status] ?? 'bg-secondary' }} rounded-pill px-3">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-5 text-muted">Belum ada pesanan masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
