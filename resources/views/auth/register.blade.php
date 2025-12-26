<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun - Smart Canteen</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #fff5e6;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .auth-card {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: 15px;
            border: 1px solid #ffdec2;
            box-shadow: 0 10px 25px rgba(255, 126, 0, 0.1);
            overflow: hidden;
        }

        .auth-header {
            background-color: #ff7e00;
            padding: 25px;
            text-align: center;
            color: white;
        }

        .btn-orange {
            background-color: #ff7e00;
            color: white;
            border: none;
            width: 100%;
            padding: 10px;
            border-radius: 8px;
            font-weight: bold;
        }

        .btn-orange:hover {
            background-color: #e66000;
            color: white;
        }

        .form-control:focus {
            border-color: #ff7e00;
            box-shadow: 0 0 0 0.2rem rgba(255, 126, 0, 0.25);
        }
    </style>
</head>

<body>

    <div class="auth-card">
        <div class="auth-header">
            <h4 class="mb-0 fw-bold">Buat Akun Baru</h4>
            <p class="mb-0 small opacity-75">Gabung TakeEat Sekarang!</p>
        </div>
        <div class="p-4">

            @if ($errors->any())
                <div class="alert alert-danger small">
                    <ul class="mb-0 ps-3">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('register') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small text-muted">Nama</label>
                    <input type="text" name="nama" class="form-control" required
                        placeholder="Contoh: Budi Santoso" value="{{ old('nama') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Email Kampus / Pribadi</label>
                    <input type="email" name="email" class="form-control" required
                        placeholder="budi@student.univ.ac.id" value="{{ old('email') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Nomor WhatsApp</label>
                    <input type="number" name="no_hp" class="form-control" required placeholder="08123456789"
                        value="{{ old('no_hp') }}">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Password</label>
                    <input type="password" name="password" class="form-control" required
                        placeholder="Minimal 6 karakter">
                    <small class="text-muted" style="font-size: 10px;">*Minimal 6 karakter</small>
                </div>

                <button type="submit" class="btn btn-orange mt-3">Daftar Sekarang</button>
            </form>

            <div class="text-center mt-4">
                <p class="small text-muted">Sudah punya akun? <a href="{{ route('login') }}"
                        class="text-decoration-none fw-bold" style="color: #ff7e00;">Login disini</a></p>
            </div>
        </div>
    </div>

</body>

</html>
