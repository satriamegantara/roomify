<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Daftar - Roomify | Platform Kos-kosan Terpercaya</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    <!-- Bootstrap CSS & Vite -->
    @vite(['resources/css/app.css', 'resources/css/auth.css', 'resources/js/app.js'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

</head>

<body>
    <div class="auth-container register-page">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-xl-9">
                    <div class="auth-card">
                        <div class="row g-0">
                            <!-- Left Side - Illustration -->
                            <div class="col-md-5 auth-left">
                                <div class="auth-illustration text-center mb-4">
                                    <i class="bi bi-person-plus-fill register-icon"></i>
                                </div>
                                <div class="logo-text text-center">Bergabung dengan Roomify</div>
                                <p class="welcome-text text-center">
                                    Mulai perjalanan Anda menemukan hunian ideal dengan fitur-fitur terlengkap.
                                </p>
                                <div class="benefit-list">
                                    <div class="benefit-item">
                                        <i class="bi bi-check-circle-fill"></i>
                                        <span>Gratis & Mudah Digunakan</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="bi bi-bell-fill"></i>
                                        <span>Notifikasi Real-time</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="bi bi-chat-dots-fill"></i>
                                        <span>Chat dengan Pemilik Kos</span>
                                    </div>
                                    <div class="benefit-item">
                                        <i class="bi bi-bookmark-fill"></i>
                                        <span>Simpan & Kelola Favorit</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Right Side - Register Form -->
                            <div class="col-md-7 auth-right">
                                <div class="mb-4">
                                    <h2 class="fw-bold mb-2" style="color: #1f2937;">Buat Akun Baru</h2>
                                    <p class="text-muted">Lengkapi data di bawah untuk mendaftar</p>
                                </div>

                                <!-- Error Messages -->
                                @if ($errors->any())
                                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                        <strong><i class="bi bi-exclamation-triangle me-2"></i>Terjadi Kesalahan!</strong>
                                        <ul class="mb-0 mt-2">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                                    </div>
                                @endif

                                <!-- Register Form -->
                                <form method="POST" action="{{ route('register') }}">
                                    @csrf

                                    <!-- Name -->
                                    <div class="form-floating mb-3">
                                        <input type="text" class="form-control @error('name') is-invalid @enderror"
                                            id="name" name="name" value="{{ old('name') }}" placeholder="Nama Lengkap"
                                            required autofocus autocomplete="name">
                                        <label for="name"><i class="bi bi-person me-2"></i>Nama Lengkap</label>
                                        @error('name')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Email Address -->
                                    <div class="form-floating mb-3">
                                        <input type="email" class="form-control @error('email') is-invalid @enderror"
                                            id="email" name="email" value="{{ old('email') }}"
                                            placeholder="name@example.com" required autocomplete="username">
                                        <label for="email"><i class="bi bi-envelope me-2"></i>Email</label>
                                        @error('email')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Role -->
                                    <div class="form-floating mb-3">
                                        <select class="form-select @error('role') is-invalid @enderror" id="role"
                                            name="role" required>
                                            <option value="" disabled selected>Pilih peran Anda</option>
                                            <option value="penyewa" {{ old('role') == 'penyewa' ? 'selected' : '' }}>
                                                Penyewa (Mencari Kos)</option>
                                            <option value="pemilik" {{ old('role') == 'pemilik' ? 'selected' : '' }}>
                                                Pemilik Kos</option>
                                        </select>
                                        <label for="role"><i class="bi bi-person-badge me-2"></i>Daftar Sebagai</label>
                                        @error('role')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Password -->
                                    <div class="form-floating mb-3">
                                        <input type="password"
                                            class="form-control @error('password') is-invalid @enderror" id="password"
                                            name="password" placeholder="Password" required autocomplete="new-password">
                                        <label for="password"><i class="bi bi-lock me-2"></i>Password</label>
                                        @error('password')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                        <small class="text-muted">Minimal 8 karakter</small>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div class="form-floating mb-4">
                                        <input type="password"
                                            class="form-control @error('password_confirmation') is-invalid @enderror"
                                            id="password_confirmation" name="password_confirmation"
                                            placeholder="Konfirmasi Password" required autocomplete="new-password">
                                        <label for="password_confirmation"><i
                                                class="bi bi-lock-fill me-2"></i>Konfirmasi
                                            Password</label>
                                        @error('password_confirmation')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Terms & Conditions -->
                                    <div class="form-check mb-4">
                                        <input class="form-check-input" type="checkbox" id="terms" required>
                                        <label class="form-check-label" for="terms">
                                            Saya setuju dengan <a href="#" class="text-decoration-none"
                                                style="color: #10a37f;">Syarat & Ketentuan</a>
                                        </label>
                                    </div>

                                    <!-- Register Button -->
                                    <button type="submit" class="btn btn-auth">
                                        <i class="bi bi-person-check me-2"></i>Daftar Sekarang
                                    </button>
                                </form>

                                <!-- Login Link -->
                                <div class="text-center mt-4">
                                    <p class="text-muted mb-0">
                                        Sudah punya akun?
                                        <a href="{{ route('login') }}" class="text-decoration-none fw-semibold"
                                            style="color: #10a37f;">
                                            Login Di Sini
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