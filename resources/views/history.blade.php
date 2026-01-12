<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pesanan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body class="bg-light">

    @include('layouts.navbar')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <h3 class="fw-bold mb-4"><i class="bi bi-clock-history text-orange"></i> Riwayat Pesananmu</h3>

                <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th class="ps-4 py-3">Tanggal</th>
                                        <th>Menu yang Dipesan</th>
                                        <th>Total Harga</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($orders as $order)
                                        <tr>
                                            <td class="ps-4">
                                                <div class="fw-bold">{{ $order->created_at->format('d M Y') }}</div>
                                                <small class="text-muted">{{ $order->created_at->format('H:i') }}
                                                    WIB</small>
                                            </td>
                                            <td>
                                                <ul class="list-unstyled mb-0 small">
                                                    @foreach ($order->details as $detail)
                                                        <li>
                                                            <span
                                                                class="fw-bold text-orange">{{ $detail->jumlah }}x</span>
                                                            {{ $detail->product->nama_produk ?? 'Menu Dihapus' }}
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            </td>
                                            <td class="fw-bold">Rp {{ number_format($order->total_harga, 0, ',', '.') }}
                                            </td>
                                            <td>
                                                @php
                                                    $statusColor = [
                                                        'menunggu_konfirmasi' => 'warning',
                                                        'diproses' => 'info',
                                                        'selesai' => 'success',
                                                        'batal' => 'danger',
                                                    ];
                                                @endphp
                                                <span
                                                    class="badge rounded-pill bg-{{ $statusColor[$order->status] ?? 'secondary' }} px-3 py-2">
                                                    {{ ucfirst(str_replace('_', ' ', $order->status)) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center py-5">
                                                <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png"
                                                    width="80" class="mb-3 opacity-50">
                                                <p class="text-muted fw-bold">Belum ada riwayat pesanan.</p>
                                                <a href="{{ route('katalog') }}"
                                                    class="btn btn-sm btn-orange rounded-pill px-4">Pesan Sekarang</a>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
