<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Saya - Smart Canteen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>

    @include('layouts.navbar')

    <div class="container my-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm rounded-4">
                    <div class="card-body p-4">

                        @if (session('success'))
                            <div class="alert alert-success border-0 shadow-sm mb-4">{{ session('success') }}</div>
                        @endif

                        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-5 text-center position-relative">
                                <div class="d-inline-block position-relative">
                                    <div class="rounded-circle border border-3 border-white shadow overflow-hidden"
                                        style="width: 150px; height: 150px; background-color: #f0f0f0;">
                                        @if (auth()->user()->foto_profil)
                                            <img id="avatar-preview"
                                                src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                                class="w-100 h-100 object-fit-cover">
                                        @else
                                            <img id="avatar-preview"
                                                src="https://ui-avatars.com/api/?name={{ urlencode($user->nama) }}&background=ff7e00&color=fff&size=150"
                                                class="w-100 h-100 object-fit-cover">
                                        @endif
                                    </div>

                                    <label for="foto_input"
                                        class="position-absolute bottom-0 end-0 bg-white text-orange shadow rounded-circle d-flex align-items-center justify-content-center cursor-pointer"
                                        style="width: 40px; height: 40px; border: 2px solid #ff7e00;"
                                        title="Ganti Foto">
                                        <i class="bi bi-pencil-fill fs-6 text-orange"></i>
                                    </label>

                                    @if (auth()->user()->foto_profil)
                                        <button type="button"
                                            class="position-absolute bottom-0 start-0 bg-danger text-white shadow rounded-circle d-flex align-items-center justify-content-center border-0"
                                            style="width: 40px; height: 40px;"
                                            onclick="if(confirm('Yakin mau hapus foto profil?')) document.getElementById('form-hapus-foto').submit();"
                                            title="Hapus Foto">
                                            <i class="bi bi-trash-fill fs-6"></i>
                                        </button>
                                    @endif
                                </div>
                                <input type="file" id="foto_input" name="foto_profil" class="d-none" accept="image/*"
                                    onchange="previewImage()">
                                <div class="mt-3 text-muted small">Klik ikon pensil untuk mengubah foto</div>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Nama Lengkap</label>
                                <input type="text" name="nama" class="form-control" value="{{ $user->nama }}"
                                    required>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">Email (Tidak bisa diubah)</label>
                                <input type="email" class="form-control bg-light" value="{{ $user->email }}"
                                    readonly>
                            </div>

                            <div class="mb-3">
                                <label class="form-label small text-muted">No. WhatsApp</label>
                                <input type="number" name="no_hp" class="form-control" value="{{ $user->no_hp }}"
                                    required>
                            </div>

                            <hr class="my-4">

                            <div class="mb-3">
                                <label class="form-label small text-muted">Password Baru (Opsional)</label>
                                <input type="password" name="password" class="form-control"
                                    placeholder="Isi jika ingin mengganti password">
                            </div>

                            <button type="submit" class="btn btn-orange w-100 py-2 fw-bold rounded-pill">Simpan
                                Perubahan</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form id="form-hapus-foto" action="{{ route('profile.delete_photo') }}" method="POST" class="d-none">
        @csrf @method('DELETE')
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function previewImage() {
            const image = document.querySelector('#avatar-preview');
            const input = document.querySelector('#foto_input');
            const oFReader = new FileReader();
            oFReader.readAsDataURL(input.files[0]);
            oFReader.onload = function(oFREvent) {
                image.src = oFREvent.target.result;
            }
        }
    </script>
</body>

</html>
