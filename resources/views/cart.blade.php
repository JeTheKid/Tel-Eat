<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Saya</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-5">
        @if (session('success'))
            <div class="alert alert-success border-0 shadow-sm">{{ session('success') }}</div>
        @endif

        <div class="row">
            <div class="col-md-8">
                <div class="card border-0 shadow-sm rounded-4 mb-3">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-4">Keranjang Pesanan</h5>

                        @if (session('cart'))
                            @foreach (session('cart') as $id => $details)
                                <div class="d-flex align-items-center mb-3 border-bottom pb-3">
                                    <div class="me-3">
                                        @if ($details['image'])
                                            <img src="{{ asset('storage/' . $details['image']) }}" width="80"
                                                height="80" class="rounded object-fit-cover">
                                        @else
                                            <div class="bg-light rounded d-flex align-items-center justify-content-center"
                                                style="width:80px; height:80px">
                                                <i class="bi bi-image-fill fs-1 opacity-25"></i>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="fw-bold mb-1">{{ $details['name'] }}</h6>
                                        <small class="text-muted">Rp {{ number_format($details['price'], 0, ',', '.') }}
                                            x {{ $details['quantity'] }}</small>
                                    </div>
                                    <div class="fw-bold text-orange me-3">
                                        Rp {{ number_format($details['price'] * $details['quantity'], 0, ',', '.') }}
                                    </div>
                                    <button class="btn btn-sm btn-outline-danger border-0 remove-from-cart"
                                        data-id="{{ $id }}">
                                        <i class="bi bi-trash"></i>
                                    </button>
                                </div>
                            @endforeach
                        @else
                            <div class="text-center py-5">
                                <i class="bi bi-basket fs-1 text-muted"></i>
                                <p class="text-muted mt-2">Keranjang masih kosong.</p>
                                <a href="{{ route('katalog') }}" class="btn btn-sm btn-orange">Belanja Dulu</a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <div class="col-md-4">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3">Ringkasan</h5>
                        @php $total = 0 @endphp
                        @foreach ((array) session('cart') as $id => $details)
                            @php $total += $details['price'] * $details['quantity'] @endphp
                        @endforeach

                        <div class="d-flex justify-content-between mb-2">
                            <span>Total Harga</span>
                            <span class="fw-bold">Rp {{ number_format($total, 0, ',', '.') }}</span>
                        </div>
                        <hr>
                        @if (session('cart'))
                            <a href="{{ route('checkout.page') }}"
                                class="btn btn-orange w-100 fw-bold py-2 rounded-pill">
                                Lanjut Pembayaran <i class="bi bi-arrow-right"></i>
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script type="text/javascript">
        $(".remove-from-cart").click(function(e) {
            e.preventDefault();
            var ele = $(this);
            if (confirm("Yakin hapus menu ini?")) {
                $.ajax({
                    url: '{{ route('remove_from_cart') }}',
                    method: "DELETE",
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: ele.attr("data-id")
                    },
                    success: function(response) {
                        window.location.reload();
                    }
                });
            }
        });
    </script>
</body>

</html>
