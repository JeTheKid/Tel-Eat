@extends('layouts.sidebar')

@section('content')
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="fw-bold text-dark">Kelola Metode Pembayaran</h3>
            <button type="button" class="btn btn-orange rounded-pill px-4 fw-bold shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
                <i class="bi bi-plus-lg"></i> Tambah Rekening
            </button>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="bg-light">
                            <tr>
                                <th>Bank / E-Wallet</th>
                                <th>Nomor Rekening</th>
                                <th>Atas Nama</th>
                                <th>QRIS</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rekenings as $item)
                                <tr>
                                    <td class="fw-bold">{{ $item->nama_bank }}</td>
                                    <td class="font-monospace">{{ $item->nomor_rekening }}</td>
                                    <td>{{ $item->atas_nama }}</td>
                                    <td>
                                        @if ($item->foto_qris)
                                            <img src="{{ asset('gambar/' . $item->foto_qris) }}" width="40"
                                                class="rounded border">
                                        @else
                                            <span class="badge bg-light text-muted border">No QRIS</span>
                                        @endif
                                    </td>
                                    <td>
                                        <button class="btn btn-sm btn-warning me-1" data-bs-toggle="modal"
                                            data-bs-target="#modalEdit{{ $item->id }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>

                                        <form action="{{ route('settings.destroy', $item->id) }}" method="POST"
                                            class="d-inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"
                                                onclick="return confirm('Yakin hapus rekening ini?')">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>

                                <div class="modal fade" id="modalEdit{{ $item->id }}" tabindex="-1">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title">Edit Rekening</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                            </div>
                                            <form action="{{ route('settings.update', $item->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label class="form-label">Nama Bank / E-Wallet</label>
                                                        <input type="text" name="nama_bank" class="form-control"
                                                            value="{{ $item->nama_bank }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Nomor Rekening</label>
                                                        <input type="text" name="nomor_rekening" class="form-control"
                                                            value="{{ $item->nomor_rekening }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Atas Nama</label>
                                                        <input type="text" name="atas_nama" class="form-control"
                                                            value="{{ $item->atas_nama }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Ganti Foto QRIS (Opsional)</label>
                                                        <input type="file" name="foto_qris" class="form-control"
                                                            accept="image/*">
                                                        <small class="text-muted">Biarkan kosong jika tidak ingin mengganti
                                                            gambar.</small>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-bs-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-orange fw-bold shadow-sm">Simpan Perubahan</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modalTambah" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold">Tambah Rekening Baru</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('settings.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Nama Metode</label>
                            <input type="text" name="nama_bank" class="form-control"
                                placeholder="Contoh: QRIS, BCA, Dana" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nomor Rekening (Opsional)</label>
                            <input type="text" name="nomor_rekening" class="form-control"
                                placeholder="Kosongkan jika hanya upload QRIS">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Atas Nama (Opsional)</label>
                            <input type="text" name="atas_nama" class="form-control"
                                placeholder="Kosongkan jika hanya upload QRIS">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Foto QRIS</label>
                            <input type="file" name="foto_qris" class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-orange fw-bold shadow-sm">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
