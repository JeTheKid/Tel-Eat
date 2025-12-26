<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tel-Eat Admin - @yield('title')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">

    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-2 sidebar p-0">
                <div class="p-4 text-center border-bottom border-secondary">
                    <h4 class="fw-bold text-orange mb-0"><i class="bi bi-egg-fried"></i> Tel-Eat</h4>
                    <small class="text-muted">Admin Panel</small>
                </div>

                <nav class="nav flex-column mt-3">
                    <a class="nav-link {{ Request::routeIs('admin.dashboard') ? 'active' : '' }}"
                        href="{{ route('admin.dashboard') }}">
                        <i class="bi bi-speedometer2 me-2"></i> Dashboard
                    </a>

                    <a class="nav-link {{ Request::routeIs('products.*') ? 'active' : '' }}"
                        href="{{ route('products.index') }}">
                        <i class="bi bi-grid me-2"></i> Kelola Menu
                    </a>

                    <a class="nav-link {{ Request::routeIs('admin.orders.*') ? 'active' : '' }}"
                        href="{{ route('admin.orders.index') }}">
                        <i class="bi bi-cart-check me-2"></i> Pesanan Masuk
                    </a>

                    <a class="nav-link {{ Request::routeIs('admin.settings.*') ? 'active' : '' }}"
                        href="{{ route('admin.settings.index') }}">
                        <i class="bi bi-gear me-2"></i> Pengaturan
                    </a>

                    <div class="mt-4 px-3">
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-outline-danger w-100 btn-sm">
                                <i class="bi bi-box-arrow-right"></i> Logout
                            </button>
                        </form>
                    </div>
                </nav>
            </div>

            <div class="col-md-10 main-content p-4">
                <nav class="navbar navbar-light bg-white shadow-sm mb-4 rounded px-3 py-3 border-bottom">
                    <span class="navbar-brand mb-0 h1 fw-bold">@yield('page-title', 'Dashboard')</span>
                    <div class="d-flex align-items-center">
                        <div class="bg-orange text-white rounded-circle d-flex align-items-center justify-content-center me-2"
                            style="width: 35px; height: 35px;">
                            {{ substr(Auth::user()->nama ?? 'Admin', 0, 1) }}
                        </div>
                        <span class="text-muted small">Halo,
                            <strong>{{ Auth::user()->nama ?? 'Admin' }}</strong></span>
                    </div>
                </nav>

                @yield('content')
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
