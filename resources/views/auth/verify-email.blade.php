<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Verifikasi Email - Roomify | Platform Kos-kosan Terpercaya</title>
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
                <div class="col-md-8 col-lg-6">
                    <div class="auth-card simple">
                        <div class="icon-wrapper">
                            <i class="bi bi-envelope-check-fill"></i>
                        </div>

                        <h2 class="text-center fw-bold mb-2" style="color: #1f2937;">Verifikasi Email</h2>
                        <p class="text-center text-muted mb-4">
                            Terima kasih telah mendaftar! Sebelum memulai, silakan verifikasi alamat email Anda dengan
                            mengklik link yang kami kirim. Jika Anda tidak menerima email, kami dengan senang hati akan
                            mengirimkan yang lain.
                        </p>

                        <!-- Success Message -->
                        @if (session('status') == 'verification-link-sent')
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                <i class="bi bi-check-circle me-2"></i>Link verifikasi telah dikirim ke email Anda.
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <!-- Resend Button -->
                        <form method="POST" action="{{ route('verification.send') }}" class="mb-3">
                            @csrf
                            <button type="submit" class="btn btn-auth w-100">
                                <i class="bi bi-send me-2"></i>Kirim Ulang Email Verifikasi
                            </button>
                        </form>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="mb-0">
                            @csrf
                            <button type="submit" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-box-arrow-right me-2"></i>Keluar
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>