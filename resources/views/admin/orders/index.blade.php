@extends('layouts.sidebar')

@section('title', 'Orders')
@section('page-title', 'Orders')

@section('content')

    <div class="mb-4">
        <h4 class="fw-bold mb-1 text-dark">Transaksi & Pesanan</h4>
        <p class="text-muted small mb-0">Pantau pesanan masuk, konfirmasi pembayaran, dan update status.</p>
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
                        <th class="ps-4 py-3 text-secondary text-uppercase small fw-bold">ID Order</th>
                        <th class="text-secondary text-uppercase small fw-bold">Pelanggan</th>
                        <th class="text-secondary text-uppercase small fw-bold">Menu Dipesan</th>
                        <th class="text-secondary text-uppercase small fw-bold">Total & Bukti</th>
                        <th class="text-secondary text-uppercase small fw-bold">Status</th>
                        <th class="text-secondary text-uppercase small fw-bold text-end pe-4">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr>
                            <td class="ps-4 fw-bold text-orange">
                                #{{ $order->id_order }}
                            </td>

                            <td>
                                <div class="fw-bold text-dark">{{ $order->user->nama ?? 'User Terhapus' }}</div>
                                <div class="d-flex align-items-center text-muted small mt-1">
                                    <i class="bi bi-whatsapp me-1"></i> {{ $order->user->no_hp ?? '-' }}
                                </div>
                                <div class="text-muted small">
                                    <i class="bi bi-clock me-1"></i> {{ $order->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <td>
                                <ul class="list-unstyled mb-0 small">
                                    @foreach ($order->details as $detail)
                                        <li class="mb-1">
                                            <span class="fw-bold text-dark">{{ $detail->jumlah }}x</span>
                                            {{ $detail->product->nama_produk ?? 'Menu Dihapus' }}
                                        </li>
                                    @endforeach
                                </ul>
                            </td>

                            <td>
                                <div class="fw-bold text-dark mb-1">Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                </div>
                                @if ($order->bukti_bayar)
                                    <a href="{{ asset('gambar/' . $order->bukti_bayar) }}" target="_blank"
                                        class="btn btn-sm btn-light border text-primary shadow-sm py-0 px-2"
                                        style="font-size: 0.75rem;">
                                        <i class="bi bi-image me-1"></i> Lihat Bukti
                                    </a>
                                @else
                                    <span class="badge bg-light text-danger border">Belum Upload</span>
                                @endif
                            </td>

                            <td>
                                @php
                                    $badges = [
                                        'menunggu_konfirmasi' => 'bg-warning text-dark',
                                        'diproses' => 'bg-info text-white',
                                        'selesai' => 'bg-success text-white',
                                        'batal' => 'bg-danger text-white',
                                    ];
                                @endphp
                                <span
                                    class="badge {{ $badges[$order->status] ?? 'bg-secondary' }} rounded-pill px-3 py-2 fw-normal">
                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                </span>
                            </td>

                            <td class="text-end pe-4">
                                <div class="d-flex flex-column gap-2 align-items-end">

                                    @if ($order->status == 'menunggu_konfirmasi')
                                        <form action="{{ route('admin.orders.update', $order->id_order) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="diproses">
                                            <button type="submit" class="btn btn-sm btn-success w-100 shadow-sm"
                                                onclick="return confirm('Bukti bayar valid? Terima pesanan ini?')">
                                                <i class="bi bi-check-lg me-1"></i> Terima
                                            </button>
                                        </form>

                                        <form action="{{ route('admin.orders.update', $order->id_order) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="batal">
                                            <button type="submit"
                                                class="btn btn-sm btn-outline-danger w-100 shadow-sm border-0 bg-white"
                                                onclick="return confirm('Yakin tolak pesanan ini?')">
                                                <i class="bi bi-x-lg me-1"></i> Tolak
                                            </button>
                                        </form>
                                    @endif

                                    @if ($order->status == 'diproses')
                                        <form action="{{ route('admin.orders.update', $order->id_order) }}" method="POST">
                                            @csrf @method('PUT')
                                            <input type="hidden" name="status" value="selesai">
                                            <button type="submit"
                                                class="btn btn-sm btn-orange text-white w-100 shadow-sm fw-bold">
                                                <i class="bi bi-check2-circle me-1"></i> Selesai
                                            </button>
                                        </form>
                                    @endif

                                    @if ($order->status == 'selesai')
                                        <span class="text-muted small"><i class="bi bi-check-all text-success"></i>
                                            Tuntas</span>
                                    @endif
                                    @if ($order->status == 'batal')
                                        <span class="text-muted small"><i class="bi bi-x-circle"></i> Dibatalkan</span>
                                    @endif

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-5">
                                <div class="py-4">
                                    <i class="bi bi-inbox text-muted opacity-25" style="font-size: 4rem;"></i>
                                    <p class="fw-bold text-muted mt-3 mb-1">Tidak ada pesanan masuk</p>
                                    <p class="text-secondary small">Pesanan baru akan muncul di sini secara otomatis.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
