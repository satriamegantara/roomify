@extends('layouts.app')

@section('title', 'Roomify - Platform Kos-kosan Terpercaya')

@section('content')
    <!-- Hero Section -->
    <section class="hero-section-landing">
        <div class="container-lg">
            <div class="row align-items-center min-vh-100">
                <!-- Left Content -->
                <div class="col-lg-6 mb-5 mb-lg-0">
                    <div class="hero-content">
                        <h1 class="hero-title-main mb-4">
                            Temukan Kos Impianmu dengan <span class="text-primary">Mudah</span>
                        </h1>
                        <p class="hero-subtitle-main mb-4">
                            Platform terpercaya untuk mencari kos berkualitas di seluruh kota. Ratusan pilihan kos dengan
                            harga terjangkau, fasilitas lengkap, dan lokasi strategis menunggu Anda.
                        </p>

                        <!-- Search Box -->
                        <form action="{{ route('kos.search') }}" method="GET" class="search-form-hero mb-4">
                            <div class="input-group input-group-lg shadow-sm">
                                <span class="input-group-text bg-white border-0">
                                    <i class="bi bi-geo-alt text-primary"></i>
                                </span>
                                <input type="text" name="q" class="form-control border-0"
                                    placeholder="Cari alamat atau kota..." value="{{ request('q') }}">
                                <button class="btn btn-primary" type="submit">
                                    <i class="bi bi-search me-2"></i>Cari Sekarang
                                </button>
                            </div>
                        </form>

                        <!-- CTA Buttons -->
                        <div class="d-flex gap-3 flex-wrap">
                            <a href="{{ route('kos.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                                <i class="bi bi-search me-2"></i>Jelajahi Kos
                            </a>
                            <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                                <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                            </a>
                        </div>

                        <!-- Stats -->
                        <div class="hero-stats mt-5">
                            <div class="stat-item">
                                <h3 class="stat-number text-primary">5000+</h3>
                                <p class="stat-label">Kos Terdaftar</p>
                            </div>
                            <div class="stat-item">
                                <h3 class="stat-number text-primary">50000+</h3>
                                <p class="stat-label">Pengguna Aktif</p>
                            </div>
                            <div class="stat-item">
                                <h3 class="stat-number text-primary">98%</h3>
                                <p class="stat-label">Kepuasan Pengguna</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Illustration -->
                <div class="col-lg-6">
                    <div class="hero-illustration">
                        <div class="illustration-bg">
                            <i class="bi bi-house-fill"></i>
                        </div>
                        <div class="floating-card card-1">
                            <div class="card-icon">
                                <i class="bi bi-check-circle-fill text-success"></i>
                            </div>
                            <div class="card-text">
                                <p class="fw-bold small mb-1">Terverifikasi</p>
                                <p class="text-muted small">Semua kos sudah diverifikasi</p>
                            </div>
                        </div>
                        <div class="floating-card card-2">
                            <div class="card-icon">
                                <i class="bi bi-star-fill text-warning"></i>
                            </div>
                            <div class="card-text">
                                <p class="fw-bold small mb-1">Rating 4.8/5</p>
                                <p class="text-muted small">Dari 10K+ review</p>
                            </div>
                        </div>
                        <div class="floating-card card-3">
                            <div class="card-icon">
                                <i class="bi bi-lightning-fill text-primary"></i>
                            </div>
                            <div class="card-text">
                                <p class="fw-bold small mb-1">Proses Cepat</p>
                                <p class="text-muted small">Booking dalam 5 menit</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section class="features-section py-5">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">Mengapa Memilih Roomify?</h2>
                <p class="section-subtitle">Kami menyediakan solusi terbaik untuk kebutuhan kos Anda</p>
            </div>

            <div class="row g-4">
                <!-- Feature 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-shield-check"></i>
                        </div>
                        <h4 class="feature-title">Terverifikasi & Aman</h4>
                        <p class="feature-text">Semua pemilik kos dan properti sudah melalui proses verifikasi ketat untuk
                            keamanan Anda.</p>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-geo-alt-fill"></i>
                        </div>
                        <h4 class="feature-title">Lokasi Strategis</h4>
                        <p class="feature-text">Ribuan kos di lokasi strategis, dekat kampus, kantor, dan pusat
                            perbelanjaan.</p>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <h4 class="feature-title">Review & Rating</h4>
                        <p class="feature-text">Rating dan review asli dari pengguna nyata membantu Anda membuat keputusan
                            terbaik.</p>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-lightning-fill"></i>
                        </div>
                        <h4 class="feature-title">Proses Cepat</h4>
                        <p class="feature-text">Booking online yang mudah dan cepat tanpa harus repot datang langsung ke
                            kos.</p>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-credit-card"></i>
                        </div>
                        <h4 class="feature-title">Pembayaran Mudah</h4>
                        <p class="feature-text">Berbagai metode pembayaran tersedia untuk kemudahan transaksi Anda.</p>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-headset"></i>
                        </div>
                        <h4 class="feature-title">Customer Support</h4>
                        <p class="feature-text">Tim support 24/7 siap membantu menjawab semua pertanyaan Anda.</p>
                    </div>
                </div>

                <!-- Feature 7 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-camera-fill"></i>
                        </div>
                        <h4 class="feature-title">Foto Lengkap</h4>
                        <p class="feature-text">Galeri foto lengkap dari berbagai sudut untuk melihat kondisi kos secara
                            detail.</p>
                    </div>
                </div>

                <!-- Feature 8 -->
                <div class="col-md-6 col-lg-3">
                    <div class="feature-card h-100">
                        <div class="feature-icon">
                            <i class="bi bi-chat-dots-fill"></i>
                        </div>
                        <h4 class="feature-title">Chat Langsung</h4>
                        <p class="feature-text">Komunikasi langsung dengan pemilik kos untuk menjawab pertanyaan spesifik
                            Anda.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="how-it-works-section py-5 bg-light">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">Cara Kerja Roomify</h2>
                <p class="section-subtitle">4 langkah mudah untuk menemukan kos impian Anda</p>
            </div>

            <div class="row g-4 align-items-center">
                <!-- Step 1 -->
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">1</div>
                        <div class="step-icon">
                            <i class="bi bi-search"></i>
                        </div>
                        <h4 class="step-title">Cari Kos</h4>
                        <p class="step-text">Gunakan fitur pencarian dan filter untuk menemukan kos sesuai kebutuhan Anda.
                        </p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="col-lg-3 text-center d-none d-lg-block">
                    <i class="bi bi-arrow-right text-primary step-arrow"></i>
                </div>

                <!-- Step 2 -->
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">2</div>
                        <div class="step-icon">
                            <i class="bi bi-heart-fill"></i>
                        </div>
                        <h4 class="step-title">Lihat Detail</h4>
                        <p class="step-text">Lihat foto, fasilitas, lokasi, dan review dari pengguna lain.</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="col-lg-3 text-center d-none d-lg-block">
                    <i class="bi bi-arrow-right text-primary step-arrow"></i>
                </div>

                <!-- Step 3 -->
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">3</div>
                        <div class="step-icon">
                            <i class="bi bi-calendar-check"></i>
                        </div>
                        <h4 class="step-title">Booking</h4>
                        <p class="step-text">Lakukan booking online dan pilih tanggal mulai tinggal Anda.</p>
                    </div>
                </div>

                <!-- Arrow -->
                <div class="col-lg-3 text-center d-none d-lg-block">
                    <i class="bi bi-arrow-right text-primary step-arrow"></i>
                </div>

                <!-- Step 4 -->
                <div class="col-md-6 col-lg-3">
                    <div class="step-card">
                        <div class="step-number">4</div>
                        <div class="step-icon">
                            <i class="bi bi-check-circle"></i>
                        </div>
                        <h4 class="step-title">Selesai!</h4>
                        <p class="step-text">Bayar dan mulai tinggal di kos pilihan Anda dengan nyaman.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Categories Section -->
    <section class="categories-section py-5">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">Jenis-Jenis Kos</h2>
                <p class="section-subtitle">Pilih jenis kos yang sesuai dengan preferensi Anda</p>
            </div>

            <div class="row g-4">
                <!-- Kos Putra -->
                <div class="col-md-6 col-lg-4">
                    <div class="category-card">
                        <div class="category-icon text-primary">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>
                        <h4 class="category-title">Kos Putra</h4>
                        <p class="category-text">Kos khusus untuk laki-laki dengan fasilitas lengkap dan lingkungan yang
                            kondusif.</p>
                        <a href="{{ route('kos.search', ['jenis_kos' => 'putra']) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>

                <!-- Kos Putri -->
                <div class="col-md-6 col-lg-4">
                    <div class="category-card">
                        <div class="category-icon text-danger">
                            <i class="bi bi-person-vcard-fill"></i>
                        </div>
                        <h4 class="category-title">Kos Putri</h4>
                        <p class="category-text">Kos khusus untuk perempuan dengan sistem keamanan yang ketat dan nyaman.
                        </p>
                        <a href="{{ route('kos.search', ['jenis_kos' => 'putri']) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>

                <!-- Kos Campur -->
                <div class="col-md-6 col-lg-4">
                    <div class="category-card">
                        <div class="category-icon text-info">
                            <i class="bi bi-people-fill"></i>
                        </div>
                        <h4 class="category-title">Kos Campur</h4>
                        <p class="category-text">Kos untuk semua jenis kelamin dengan fasillitas umum yang lengkap dan
                            modern.</p>
                        <a href="{{ route('kos.search', ['jenis_kos' => 'campur']) }}"
                            class="btn btn-outline-primary btn-sm">
                            <i class="bi bi-arrow-right me-2"></i>Lihat Semua
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="testimonials-section py-5 bg-light">
        <div class="container-lg">
            <div class="text-center mb-5">
                <h2 class="section-title">Apa Kata Pengguna Kami?</h2>
                <p class="section-subtitle">Testimoni dari ribuan pengguna yang puas</p>
            </div>

            <div class="row g-4">
                <!-- Testimonial 1 -->
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"Roomify sangat membantu saya menemukan kos yang sesuai dengan budget
                            dan kebutuhan. Prosesnya mudah dan cepat!"</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="author-info">
                                <p class="author-name">Ahmad Hidayat</p>
                                <p class="author-role">Mahasiswa</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 2 -->
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"Sebagai pemilik kos, Roomify memberikan platform yang user-friendly
                            untuk mengelola properti saya dengan mudah."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="author-info">
                                <p class="author-name">Siti Nurhaliza</p>
                                <p class="author-role">Pemilik Kos</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Testimonial 3 -->
                <div class="col-md-6 col-lg-4">
                    <div class="testimonial-card h-100">
                        <div class="testimonial-stars">
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                            <i class="bi bi-star-fill"></i>
                        </div>
                        <p class="testimonial-text">"Tim support Roomify sangat responsif dan membantu. Mereka selalu siap
                            menjawab setiap pertanyaan saya dengan cepat."</p>
                        <div class="testimonial-author">
                            <div class="author-avatar">
                                <i class="bi bi-person-circle"></i>
                            </div>
                            <div class="author-info">
                                <p class="author-name">Budi Santoso</p>
                                <p class="author-role">Karyawan</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="cta-section py-5">
        <div class="container-lg">
            <div class="cta-content text-center">
                <h2 class="cta-title mb-4">Siap Menemukan Kos Impianmu?</h2>
                <p class="cta-subtitle mb-5">Bergabunglah dengan ribuan pengguna yang sudah menemukan kos terbaik melalui
                    Roomify</p>

                <div class="d-flex gap-3 justify-content-center flex-wrap">
                    <a href="{{ route('kos.index') }}" class="btn btn-primary btn-lg rounded-pill px-5">
                        <i class="bi bi-search me-2"></i>Cari Kos Sekarang
                    </a>
                    @guest
                        <a href="{{ route('register') }}" class="btn btn-outline-primary btn-lg rounded-pill px-5">
                            <i class="bi bi-person-plus me-2"></i>Daftar Gratis
                        </a>
                    @endguest
                </div>
            </div>
        </div>
    </section>

    <style>
        /* Landing Page Styles */
        .hero-section-landing {
            background: linear-gradient(135deg, rgba(16, 163, 127, 0.05) 0%, rgba(16, 163, 127, 0.02) 100%);
            position: relative;
            overflow: hidden;
        }

        .hero-section-landing::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(16, 163, 127, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .hero-content {
            position: relative;
            z-index: 1;
        }

        .hero-title-main {
            font-size: 3rem;
            font-weight: 800;
            line-height: 1.2;
            color: var(--kosan-dark);
            margin-bottom: 1.5rem;
        }

        .hero-subtitle-main {
            font-size: 1.125rem;
            color: #6b7280;
            line-height: 1.6;
        }

        .search-form-hero {
            position: relative;
            z-index: 2;
        }

        .search-form-hero .input-group {
            border-radius: 50px;
            background: white;
        }

        .search-form-hero .input-group-text {
            border-radius: 50px 0 0 50px;
            padding: 0 1.5rem;
        }

        .search-form-hero .form-control {
            padding: 1rem 1.5rem;
            font-size: 1rem;
        }

        .search-form-hero .btn-primary {
            border-radius: 0 50px 50px 0;
            padding: 0.75rem 2rem;
            font-weight: 600;
        }

        .hero-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 2rem;
        }

        .stat-item {
            text-align: center;
        }

        .stat-number {
            font-size: 1.75rem;
            font-weight: 800;
        }

        .stat-label {
            font-size: 0.9rem;
            color: #6b7280;
            margin-top: 0.5rem;
        }

        /* Illustration */
        .hero-illustration {
            position: relative;
            height: 500px;
        }

        .illustration-bg {
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, var(--kosan-primary) 0%, var(--kosan-primary-light) 100%);
            border-radius: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 200px;
            color: white;
            opacity: 0.1;
        }

        .floating-card {
            position: absolute;
            background: white;
            padding: 1rem;
            border-radius: 12px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            display: flex;
            gap: 1rem;
            align-items: center;
            animation: float 3s ease-in-out infinite;
        }

        .floating-card.card-1 {
            top: 50px;
            right: 50px;
            animation-delay: 0s;
        }

        .floating-card.card-2 {
            bottom: 100px;
            right: 30px;
            animation-delay: 0.5s;
        }

        .floating-card.card-3 {
            top: 200px;
            left: 20px;
            animation-delay: 1s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        .card-icon {
            font-size: 1.5rem;
        }

        .card-text {
            flex: 1;
        }

        /* Features Section */
        .features-section {
            background: white;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 800;
            color: var(--kosan-dark);
            margin-bottom: 0.5rem;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #6b7280;
        }

        .feature-card {
            padding: 2rem;
            border: 1px solid var(--kosan-border);
            border-radius: 12px;
            transition: all 0.3s ease;
            text-align: center;
        }

        .feature-card:hover {
            border-color: var(--kosan-primary);
            box-shadow: 0 10px 30px rgba(16, 163, 127, 0.1);
            transform: translateY(-5px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--kosan-primary) 0%, var(--kosan-primary-light) 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            margin: 0 auto 1rem;
        }

        .feature-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--kosan-dark);
            margin-bottom: 0.75rem;
        }

        .feature-text {
            color: #6b7280;
            font-size: 0.95rem;
            line-height: 1.6;
        }

        /* How It Works */
        .how-it-works-section {
            background: #f9fafb;
        }

        .step-card {
            padding: 2rem;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--kosan-border);
            position: relative;
            transition: all 0.3s ease;
        }

        .step-card:hover {
            box-shadow: 0 10px 30px rgba(16, 163, 127, 0.1);
            border-color: var(--kosan-primary);
        }

        .step-number {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--kosan-primary) 0%, var(--kosan-primary-light) 100%);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 800;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .step-icon {
            font-size: 2.5rem;
            color: var(--kosan-primary);
            margin: 1rem 0;
        }

        .step-title {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--kosan-dark);
            margin-bottom: 0.75rem;
        }

        .step-text {
            color: #6b7280;
            font-size: 0.95rem;
        }

        .step-arrow {
            font-size: 2rem;
        }

        /* Categories */
        .categories-section {
            background: white;
        }

        .category-card {
            padding: 2rem;
            border: 2px solid var(--kosan-border);
            border-radius: 12px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .category-card:hover {
            border-color: var(--kosan-primary);
            box-shadow: 0 10px 30px rgba(16, 163, 127, 0.1);
            transform: translateY(-5px);
        }

        .category-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }

        .category-title {
            font-size: 1.25rem;
            font-weight: 700;
            color: var(--kosan-dark);
            margin-bottom: 0.75rem;
        }

        .category-text {
            color: #6b7280;
            font-size: 0.95rem;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        /* Testimonials */
        .testimonials-section {
            background: #f9fafb;
        }

        .testimonial-card {
            padding: 2rem;
            background: white;
            border-radius: 12px;
            border: 1px solid var(--kosan-border);
            transition: all 0.3s ease;
        }

        .testimonial-card:hover {
            box-shadow: 0 10px 30px rgba(16, 163, 127, 0.1);
            transform: translateY(-5px);
        }

        .testimonial-stars {
            color: #fbbf24;
            margin-bottom: 1rem;
            font-size: 0.9rem;
        }

        .testimonial-text {
            color: #4b5563;
            font-size: 0.95rem;
            line-height: 1.6;
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testimonial-author {
            display: flex;
            gap: 1rem;
            align-items: center;
        }

        .author-avatar {
            font-size: 3rem;
            color: var(--kosan-primary);
        }

        .author-info {
            text-align: left;
        }

        .author-name {
            font-weight: 700;
            color: var(--kosan-dark);
            margin: 0;
            font-size: 0.95rem;
        }

        .author-role {
            color: #6b7280;
            margin: 0;
            font-size: 0.85rem;
        }

        /* CTA Section */
        .cta-section {
            background: linear-gradient(135deg, var(--kosan-primary) 0%, var(--kosan-primary-dark) 100%);
            color: white;
        }

        .cta-content {
            padding: 3rem 2rem;
        }

        .cta-title {
            font-size: 2.5rem;
            font-weight: 800;
        }

        .cta-subtitle {
            font-size: 1.1rem;
            opacity: 0.95;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title-main {
                font-size: 2rem;
            }

            .hero-subtitle-main {
                font-size: 1rem;
            }

            .section-title {
                font-size: 2rem;
            }

            .hero-illustration {
                display: none;
            }

            .hero-stats {
                grid-template-columns: 1fr;
            }

            .step-arrow {
                display: none;
            }

            .cta-title {
                font-size: 1.75rem;
            }
        }
    </style>
@endsection