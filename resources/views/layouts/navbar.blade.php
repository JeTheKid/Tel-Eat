<nav class="navbar navbar-expand-lg bg-white shadow-sm sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('katalog') }}" style="color: #ff7e00;">
            <i class="bi bi-egg-fried"></i> Tel-Eat </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center gap-3">

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('katalog') ? 'active fw-bold text-orange' : '' }}"
                       href="{{ route('katalog') }}">Catalog</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link {{ Request::routeIs('riwayat') ? 'active fw-bold text-orange' : '' }}"
                       href="{{ route('riwayat') }}">History</a>
                </li>

                <li class="nav-item">
                    <a class="nav-link position-relative {{ Request::routeIs('cart.index') ? 'active text-orange' : '' }}"
                       href="{{ route('cart.index') }}">
                        <i class="bi bi-cart3 fs-5"></i>

                        @if(session('cart') && count(session('cart')) > 0)
                            <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" style="font-size: 0.6rem;">
                                {{ count(session('cart')) }}
                            </span>
                        @endif
                    </a>
                </li>

                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                        @if(auth()->user()->foto_profil)
                            <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}"
                                 class="rounded-circle object-fit-cover border"
                                 width="35" height="35" alt="User">
                        @else
                            <div class="rounded-circle bg-secondary text-white d-flex align-items-center justify-content-center"
                                 style="width: 35px; height: 35px; font-size: 0.8rem;">
                                {{ substr(auth()->user()->nama ?? 'U', 0, 1) }}
                            </div>
                        @endif
                    </a>

                    <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                        <li><h6 class="dropdown-header">Halo, {{ Str::limit(auth()->user()->nama ?? 'Mahasiswa', 15) }}!</h6></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <a class="dropdown-item" href="{{ route('profile.index') }}">
                                <i class="bi bi-person me-2"></i> Profil Saya
                            </a>
                        </li>
                        <li>
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-danger">
                                    <i class="bi bi-box-arrow-right me-2"></i> Logout
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>

            </ul>
        </div>
    </div>
</nav>

<style>
    .text-orange { color: #ff7e00 !important; }
    .nav-link:hover { color: #ff7e00; }
</style>
