@extends('layouts.sidebar')

@section('title', 'Pengaturan')
@section('page-title', 'Pengaturan Toko')

@section('content')

    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">

            <div class="mb-4 text-center">
                <h4 class="fw-bold text-dark mb-1">Metode Pembayaran</h4>
                <p class="text-muted small">Atur nomor rekening dan QRIS untuk pembayaran pelanggan.</p>
            </div>

            @if (session('success'))
                <div class="alert alert-success border-0 shadow-sm alert-dismissible fade show mb-4" role="alert">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
                <div class="card-header bg-white py-3 border-bottom text-center">
                    <div class="d-inline-flex align-items-center justify-content-center bg-black bg-opacity-10 text-orange rounded-circle mb-2"
                        style="width: 50px; height: 50px;">
                        <i class="bi bi-wallet2 fs-4"></i>
                    </div>
                    <h6 class="fw-bold mb-0 text-dark">Data Rekening & QRIS</h6>
                </div>

                <div class="card-body p-4">
                    <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1">Informasi Bank</label>

                            <div class="mb-3">
                                <label class="form-label text-dark small mb-1">Nama Bank</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-secondary"><i
                                            class="bi bi-bank"></i></span>
                                    <input type="text" name="nama_bank" class="form-control border-start-0 ps-0"
                                        value="{{ $toko->nama_bank }}" placeholder="Contoh: BCA / GoPay">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small mb-1">Nomor Rekening</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-secondary"><i
                                            class="bi bi-credit-card-2-front"></i></span>
                                    <input type="text" name="nomor_rekening"
                                        class="form-control border-start-0 ps-0 fw-bold text-dark fs-5"
                                        value="{{ $toko->nomor_rekening }}" placeholder="1234567890">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label text-dark small mb-1">Atas Nama</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-light border-end-0 text-secondary"><i
                                            class="bi bi-person"></i></span>
                                    <input type="text" name="atas_nama" class="form-control border-start-0 ps-0"
                                        value="{{ $toko->atas_nama }}" placeholder="Nama Pemilik Rekening">
                                </div>
                            </div>
                        </div>

                        <hr class="border-secondary border-opacity-10 my-4">

                        <div class="mb-4">
                            <label class="form-label small fw-bold text-uppercase text-muted ls-1 mb-3">Scan QRIS</label>

                            <div class="d-flex align-items-start gap-4">
                                <div class="text-center">
                                    <div class="border rounded-3 p-2 bg-light mb-2 d-flex align-items-center justify-content-center"
                                        style="width: 120px; height: 120px; overflow: hidden;">
                                        @if ($toko && $toko->foto_qris)
                                            <img src="{{ asset('storage/' . $toko->foto_qris) }}"
                                                class="w-100 h-100 object-fit-contain rounded-2">
                                        @else
                                            <div class="text-muted small text-center">
                                                <i class="bi bi-qr-code fs-3 d-block opacity-50 mb-1"></i>
                                                Belum ada
                                            </div>
                                        @endif
                                    </div>

                                    <small class="text-muted d-block mb-1" style="font-size: 0.7rem;">Preview Saat
                                        Ini</small>

                                    @if ($toko && $toko->foto_qris)
                                        <form action="{{ route('admin.settings.delete_qris') }}" method="POST"
                                            onsubmit="return confirm('Yakin mau menghapus QRIS ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-link text-danger text-decoration-none p-0"
                                                style="font-size: 0.7rem;">
                                                <i class="bi bi-trash-fill"></i> Hapus
                                            </button>
                                        </form>
                                    @endif
                                </div>

                                <div class="flex-grow-1">
                                    <label class="form-label text-dark small mb-1">Upload Gambar Baru</label>
                                    <input type="file" name="foto_qris" class="form-control form-control-sm mb-2"
                                        accept="image/*">
                                    <div class="alert alert-info border-0 d-flex align-items-center p-2 mb-0"
                                        role="alert">
                                        <i class="bi bi-info-circle-fill fs-6 me-2"></i>
                                        <div style="font-size: 0.75rem; line-height: 1.2;">
                                            Pastikan QR code terbaca jelas. Format JPG/PNG, maks 2MB.
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-orange w-100 py-2 rounded-pill fw-bold shadow-sm">
                            <i class="bi bi-save me-2"></i> Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
