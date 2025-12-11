<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Roomify | Platform Kos-kosan Terpercaya</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>

<body>
    <div class="auth-container">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="auth-card">
                        <div class="row g-0">
                            <!-- Left Side - Illustration -->
                            <div class="col-md-5 auth-left">
                                <div class="auth-illustration text-center mb-4">
                                    <i class="bi bi-house-heart-fill login-icon"></i>
                                </div>
                                <div class="logo-text text-center">Roomify</div>
                                <p class="welcome-text text-center">
                                    Platform terpercaya untuk menemukan kos-kosan impian Anda dengan mudah dan cepat.
                                </p>
                                <div class="feature-list">
                                    <div class="feature-item">
                                        <i class="bi bi-shield-check"></i>
                                        <span>Terverifikasi & Terpercaya</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-geo-alt-fill"></i>
                                        <span>Lokasi Strategis</span>
                                    </div>
                                    <div class="feature-item">
                                        <i class="bi bi-star-fill"></i>
                                        <span>Rating & Review Asli</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Login Form -->
                            <div class="col-md-7 auth-right">
                                <div class="mb-4">
                                    <h2 class="fw-bold mb-2" style="color: #1f2937;">Selamat Datang Kembali!</h2>
                                    <p class="text-muted">Silakan login ke akun Anda untuk melanjutkan</p>
                                </div>

                                <!-- Session Status -->
                                @if (session('status'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <i class="bi bi-check-circle me-2"></i>{{ session('status') }}
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <!-- Error Messages -->
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Login Gagal!</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <!-- Login Form -->
                                <form method="POST" action="{{ route('login') }}">
                                    @csrf

                                    <!-- Email Address -->
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}" placeholder="name@example.com"
                                            required autofocus autocomplete="username">
                                        <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-floating mb-3">
                                        <input type="password" class="form-control @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Password" required
                                            autocomplete="current-password">
                                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Remember Me & Forgot Password -->
                                    <div class="d-flex justify-content-between align-items-center mb-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="remember" id="remember_me">
                                            <label class="form-check-label" for="remember_me">
                                                Ingat Saya
                                            </label>
                                        </div>
                                        @if (Route::has('password.request'))
                                            <a href="{{ route('password.request') }}" class="text-decoration-none"
                                                style="color: #10a37f; font-weight: 500;">
                                                Lupa Password?
                                            </a>
                                        @endif
                                    </div>

                                    <!-- Login Button -->
                                    <button type="submit" class="btn btn-auth">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>Login
                                    </button>
                                </form>

                                <!-- Register Link -->
                                <div class="text-center mt-4">
                                    <p class="text-muted mb-0">
                                        Belum punya akun?
                                        <a href="{{ route('register') }}" class="text-decoration-none fw-semibold"
                                            style="color: #10a37f;">
                                            Daftar Sekarang
                                        </a>
                                    </p>
                                </div>

                                <!-- Back to Home -->
                                <div class="text-center mt-3">
                                    <a href="{{ route('home') }}" class="text-decoration-none text-muted">
                                        <i class="bi bi-arrow-left me-1"></i>Kembali ke Beranda
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
