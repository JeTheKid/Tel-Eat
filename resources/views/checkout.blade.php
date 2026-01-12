<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Payment</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    <div class="container my-5" style="max-width: 600px;">

        {{-- Alert Error Global --}}
        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm mb-4" role="alert">
                <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow border-0 rounded-4 overflow-hidden">
            {{-- Header (Desain Lama Kamu) --}}
            <div class="card-header bg-orange text-center p-4">
                <h4 class="fw-bold mb-0 text-white">Selesaikan Pembayaran</h4>
                <p class="mb-0 opacity-75 text-white">Silakan transfer sesuai total tagihan</p>
            </div>

            <div class="card-body p-4">

                {{-- === BAGIAN METODE PEMBAYARAN BARU === --}}
                <div class="card mb-4 border overflow-hidden">
                    <div class="card-header bg-light fw-bold text-dark small text-uppercase">
                        <i class="bi bi-wallet2 me-2"></i>Metode Pembayaran
                    </div>

                    @if($banks->isEmpty())
                        <div class="p-3 text-center text-muted small">Belum ada metode pembayaran tersedia.</div>
                    @else
                        <ul class="list-group list-group-flush">
                            @foreach($banks as $bank)
                                <li class="list-group-item p-3">
                                    {{-- Cek apakah QRIS ONLY --}}
                                    @if($bank->nomor_rekening == '-' || empty($bank->nomor_rekening))
                                        <div class="text-center py-2">
                                            <span class="badge bg-dark mb-2"><i class="bi bi-qr-code-scan me-1"></i> {{ $bank->nama_bank }}</span>
                                            <br>
                                            @if($bank->foto_qris)
                                                <img src="{{ asset('gambar/' . $bank->foto_qris) }}" class="img-fluid rounded border p-1 mt-2" style="max-width: 180px;">
                                            @endif
                                        </div>
                                    @else
                                        {{-- Bank Biasa --}}
                                        <div class="d-flex align-items-center justify-content-between">
                                            <div class="d-flex align-items-center">
                                                <div class="me-3 bg-secondary bg-opacity-10 text-secondary rounded d-flex align-items-center justify-content-center fw-bold"
                                                     style="width: 45px; height: 45px; font-size: 0.8rem;">
                                                    {{ substr($bank->nama_bank, 0, 3) }}
                                                </div>
                                                <div>
                                                    <h6 class="mb-0 fw-bold">{{ $bank->nama_bank }}</h6>
                                                    <div class="text-primary fw-bold user-select-all">{{ $bank->nomor_rekening }}</div>
                                                    <small class="text-muted" style="font-size: 0.8rem;">a.n {{ $bank->atas_nama }}</small>
                                                </div>
                                            </div>

                                            {{-- Tombol Lihat QRIS (Jika ada) --}}
                                            @if($bank->foto_qris)
                                                <button type="button" class="btn btn-sm btn-light border" data-bs-toggle="modal" data-bs-target="#modalQ{{ $bank->id }}">
                                                    <i class="bi bi-qr-code"></i>
                                                </button>
                                                {{-- Modal --}}
                                                <div class="modal fade" id="modalQ{{ $bank->id }}" tabindex="-1">
                                                    <div class="modal-dialog modal-sm modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-body text-center">
                                                                <h6 class="fw-bold mb-2">{{ $bank->nama_bank }}</h6>
                                                                <img src="{{ asset('gambar/' . $bank->foto_qris) }}" class="img-fluid">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
                {{-- === SELESAI BAGIAN METODE PEMBAYARAN === --}}

                {{-- List Cart --}}
                @php $total = 0; @endphp
                <ul class="list-group mb-4">
                    @foreach ($cart as $item)
                        @php $total += $item['price'] * $item['quantity'] @endphp
                        <li class="list-group-item d-flex justify-content-between lh-sm border-0 border-bottom">
                            <div>
                                <h6 class="my-0 text-dark">{{ $item['name'] }}
                                    <small class="text-muted">x {{ $item['quantity'] }}</small>
                                </h6>
                            </div>
                            <span class="text-muted">Rp
                                {{ number_format($item['price'] * $item['quantity'], 0, ',', '.') }}</span>
                        </li>
                    @endforeach
                    <li class="list-group-item d-flex justify-content-between bg-light fw-bold">
                        <span>Total (IDR)</span>
                        <span class="text-danger">Rp {{ number_format($total, 0, ',', '.') }}</span>
                    </li>
                </ul>

                {{-- Form Upload --}}
                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_bayar"
                            class="form-control @error('bukti_bayar') is-invalid @enderror"
                            accept="image/*" required>

                        @error('bukti_bayar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                        <div class="form-text">Format: JPG, PNG, JPEG. Pastikan foto jelas.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning text-white fw-bold py-3 shadow-sm">
                            Kirim Bukti Pembayaran
                        </button>
                        <a href="{{ route('cart.index') }}" class="btn btn-light text-muted">Batal / Kembali</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
