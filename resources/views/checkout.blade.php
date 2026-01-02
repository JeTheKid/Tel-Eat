<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout & Pembayaran</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    <div class="container my-5" style="max-width: 600px;">
        <div class="card shadow border-0 rounded-4 overflow-hidden">
            <div class="card-header bg-orange text-center p-4">
                <h4 class="fw-bold mb-0">Selesaikan Pembayaran</h4>
                <p class="mb-0 opacity-75">Silakan transfer sesuai total tagihan</p>
            </div>

            <div class="card-body p-4">
                <div class="alert alert-info text-center border-0 bg-opacity-10" role="alert">
                    <small class="text-muted d-block">Transfer ke {{ $toko->nama_bank ?? 'Bank' }}</small>
                    <h3 class="fw-bold my-2 text-primary">{{ $toko->nomor_rekening ?? '-' }}</h3>
                    <small class="fw-bold">a.n. {{ $toko->atas_nama ?? 'Admin' }}</small>

                    @if ($toko && $toko->foto_qris)
                        <div class="mt-3 pt-3 border-top border-info">
                            <p class="mb-2 fw-bold small text-muted">Atau Scan QRIS:</p>
                            <img src="{{ asset('storage/' . $toko->foto_qris) }}" alt="QRIS Code"
                                class="img-fluid rounded shadow-sm bg-white p-2" style="max-width: 150px;">
                        </div>
                    @endif
                </div>

                @php $total = 0; @endphp
                <ul class="list-group mb-4">
                    @foreach ($cart as $item)
                        @php $total += $item['price'] * $item['quantity'] @endphp
                        <li class="list-group-item d-flex justify-content-between lh-sm border-0 border-bottom">
                            <div>
                                <h6 class="my-0">{{ $item['name'] }}
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

                <form action="{{ route('checkout.process') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold">Upload Bukti Transfer</label>
                        <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
                        <div class="form-text">Format: JPG, PNG, JPEG. Pastikan foto jelas dan nama pengirim sama.</div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-warning text-white fw-bold py-3">
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
