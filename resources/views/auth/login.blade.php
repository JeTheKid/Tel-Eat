<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Smart Canteen</title>
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
            max-width: 400px;
            background: white;
            border-radius: 15px;
            border: 1px solid #ffdec2;
            box-shadow: 0 10px 25px rgba(255, 126, 0, 0.1);
            overflow: hidden;
        }

        .auth-header {
            background-color: #ff7e00;
            padding: 30px 20px;
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
            <h3 class="mb-1 fw-bold">Selamat Datang!</h3>
            <p class="mb-0 opacity-75">Silakan login untuk memesan.</p>
        </div>
        <div class="p-4">

            @if (session('success'))
                <div class="alert alert-success small">{{ session('success') }}</div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger small mb-3">
                    {{ $errors->first() }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST">
                @csrf

                <div class="mb-3">
                    <label class="form-label small text-muted">Email</label>
                    <input type="email" name="email" class="form-control" required placeholder="nama@email.com">
                </div>

                <div class="mb-3">
                    <label class="form-label small text-muted">Password</label>
                    <input type="password" name="password" class="form-control" required placeholder="********">
                </div>

                <button type="submit" class="btn btn-orange mt-2">Masuk</button>
            </form>

            <div class="text-center mt-4 border-top pt-3">
                <p class="small text-muted">Mahasiswa baru? <a href="{{ route('register') }}"
                        class="text-decoration-none fw-bold" style="color: #ff7e00;">Buat Akun Disini</a></p>
            </div>
        </div>
    </div>

</body>

</html>
