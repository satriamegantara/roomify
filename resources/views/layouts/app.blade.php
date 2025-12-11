<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Kosan Hub') - Platform Informasi Kos-kosan</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

    @stack('styles')
</head>

<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-modern sticky-top">
        <div class="container-lg">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/test.png') }}" alt="Roomify Logo" height="40"
                    class="me-2 logo-img">Roomify
            </a>
            <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto align-items-lg-center gap-1">
                    <li class="nav-item">
                        <a class="nav-link px-3 rounded-pill" href="{{ route('kos.index') }}">
                            <i class="bi bi-search me-1"></i>Cari Kos
                        </a>
                    </li>
                    @auth
                        <li class="nav-item">
                            <a class="nav-link px-3 rounded-pill"
                                href="{{ Auth::user()->role === 'pemilik' ? route('pemilik.dashboard') : (Auth::user()->role === 'admin' ? route('admin.kos.index') : route('dashboard')) }}">
                                <i class="bi bi-speedometer2 me-1"></i>Dashboard
                            </a>
                        </li>
                        @if(Auth::user()->role === 'penyewa')
                            <li class="nav-item">
                                <a class="nav-link px-3 rounded-pill" href="{{ route('booking.index') }}">
                                    <i class="bi bi-calendar-check me-1"></i>Booking
                                </a>
                            </li>
                        @endif
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle px-3 rounded-pill user-menu" href="#" id="userDropdown"
                                role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-1"></i>{{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-modern shadow-lg border-0 mt-2"
                                aria-labelledby="userDropdown">
                                <li><a class="dropdown-item rounded" href="{{ route('profile.edit') }}"><i
                                            class="bi bi-person me-2"></i>Profil</a></li>
                                <li>
                                    <hr class="dropdown-divider my-1">
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item rounded text-danger"><i
                                                class="bi bi-box-arrow-right me-2"></i>Logout</button>
                                    </form>
                                </li>
                            </ul>
                        </li>
                    @else
                        <li class="nav-item">
                            <a class="nav-link px-3 rounded-pill" href="{{ route('login') }}">Login</a>
                        </li>
                        <li class="nav-item ms-lg-2">
                            <a class="btn btn-light btn-sm px-4 rounded-pill" href="{{ route('register') }}">Daftar</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <main class="min-vh-100 py-4">
        <div class="container-lg">
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong>Error!</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @if (session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            @yield('content')
            {{ $slot ?? '' }}
        </div>
    </main>

    <!-- Footer -->
    <footer class="footer-modern">
        <div class="container-lg">
            <div class="footer-content">
                <div class="footer-section">
                    <div class="footer-logo mb-3">
                        <i class="bi bi-house-fill me-2"></i>
                        <span>Roomify</span>
                    </div>
                    <p class="footer-tagline">Platform terpercaya untuk menemukan kos berkualitas di seluruh kota</p>
                    <div class="footer-socials">
                        <a href="#" class="social-link"><i class="bi bi-facebook"></i></a>
                        <a href="#" class="social-link"><i class="bi bi-twitter"></i></a>
                        <a href="https://www.instagram.com/pancarws" class="social-link"><i
                                class="bi bi-instagram"></i></a>
                    </div>
                </div>

                <div class="footer-section">
                    <h5 class="footer-title">Navigasi</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Beranda</a></li>
                        <li><a href="{{ route('kos.index') }}">Cari Kos</a></li>
                        @auth
                            <li><a
                                    href="{{ Auth::user()->role === 'pemilik' ? route('pemilik.dashboard') : (Auth::user()->role === 'admin' ? route('admin.kos.index') : route('dashboard')) }}">Dashboard</a>
                            </li>
                        @endauth
                    </ul>
                </div>

                <div class="footer-section">
                    <h5 class="footer-title">Informasi</h5>
                    <ul class="footer-links">
                        <li><a href="#">Tentang Kami</a></li>
                        <li><a href="#">Kebijakan Privasi</a></li>
                        <li><a href="#">Syarat & Ketentuan</a></li>
                        <li><a href="#">Hubungi Kami</a></li>
                    </ul>
                </div>

                <div class="footer-section">
                    <h5 class="footer-title">Kontak</h5>
                    <div class="footer-contact">
                        <div class="contact-item">
                            <i class="bi bi-envelope"></i>
                            <span>info@roomify.com</span>
                        </div>
                        <div class="contact-item">
                            <i class="bi bi-telephone"></i>
                            <span>+62 812 3456 7890</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer-divider"></div>

            <div class="footer-bottom">
                <p class="mb-0">&copy; 2025 Roomify - Platform Informasi Kos-kosan Terpercaya. Semua hak dilindungi.</p>
            </div>
        </div>
    </footer>

    @stack('scripts')
</body>

</html>