<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Booking - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-booking.css'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-house-heart-fill"></i>
            <span>Roomify</span>
        </a>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('pemilik.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.kos.index') }}">
                    <i class="bi bi-building"></i>
                    <span>Kelola Kos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.bookings.index') }}" class="active">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.pembayaran.index') }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pembayaran</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('chat.index') }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Pesan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}">
                    <i class="bi bi-globe"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="sidebar-menu">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="booking-main">
        <div class="booking-header" style="margin-bottom: 1.5rem;">
            <div class="booking-header-top">
                <div>
                    <h1 class="booking-title">
                        <i class="bi bi-eye me-2"></i>Detail Booking
                    </h1>
                    <p class="booking-subtitle">Lihat informasi lengkap booking dan lakukan tindakan</p>
                </div>
                <div class="d-flex" style="gap: 0.75rem; flex-wrap: wrap;">
                    <a href="{{ route('pemilik.bookings.index') }}" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                    @if ($booking->status === 'pending')
                        <form action="{{ route('pemilik.bookings.approve', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-success"
                                onclick="return confirm('Setujui booking ini?')">
                                <i class="bi bi-check-lg me-2"></i>Setujui
                            </button>
                        </form>
                        <form action="{{ route('pemilik.bookings.reject', $booking) }}" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-danger"
                                onclick="return confirm('Tolak booking ini?')">
                                <i class="bi bi-x-lg me-2"></i>Tolak
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="booking-table-container" style="padding: 0; overflow: hidden;">
            <div class="row g-0" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));">
                <!-- Penyewa -->
                <div style="padding: 1.5rem; border-right: 1px solid var(--border); min-height: 100%;">
                    <h4 style="font-weight: 700; margin-bottom: 1rem; color: var(--dark);">
                        <i class="bi bi-person-circle me-2 text-primary"></i>Penyewa
                    </h4>
                    <div class="booking-info" style="margin-bottom: 1rem;">
                        <div class="booking-avatar" style="width: 56px; height: 56px; font-size: 1.4rem;">
                            {{ strtoupper(substr($booking->penyewa->name, 0, 1)) }}
                        </div>
                        <div class="booking-details">
                            <h4>{{ $booking->penyewa->name }}</h4>
                            <p><i class="bi bi-envelope me-1"></i>{{ $booking->penyewa->email }}</p>
                        </div>
                    </div>
                    <p style="margin: 0; color: var(--text-muted);">
                        <i class="bi bi-telephone me-2"></i>{{ $booking->penyewa->phone ?? '-' }}
                    </p>
                </div>

                <!-- Properti Kos -->
                <div style="padding: 1.5rem; border-right: 1px solid var(--border); min-height: 100%;">
                    <h4 style="font-weight: 700; margin-bottom: 1rem; color: var(--dark);">
                        <i class="bi bi-building me-2 text-primary"></i>Properti Kos
                    </h4>
                    <div class="kos-name" style="font-size: 1.1rem;">{{ $booking->kos->alamat }}</div>
                    <div class="kos-address" style="margin-top: 0.25rem;">
                        <i class="bi bi-geo-alt"></i>
                        <span>{{ $booking->kos->alamat }}</span>
                    </div>
                    <div class="badge" style="margin-top: 0.75rem; background: #eef2ff; color: #4338ca;">
                        {{ ucfirst($booking->kos->jenis_kos) }}
                    </div>
                </div>

                <!-- Detail Booking -->
                <div style="padding: 1.5rem; min-height: 100%;">
                    <h4 style="font-weight: 700; margin-bottom: 1rem; color: var(--dark);">
                        <i class="bi bi-calendar-check me-2 text-primary"></i>Detail Booking
                    </h4>
                    @php
                        $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
                        $end = \Carbon\Carbon::parse($booking->tanggal_selesai);
                        $duration = max(1, $start->diffInDays($end) ?: 1);
                    @endphp
                    <div class="booking-dates" style="margin-bottom: 1rem;">
                        <div class="date-item">
                            <i class="bi bi-calendar-check"></i>
                            Mulai: {{ $start->format('d M Y') }}
                        </div>
                        <div class="date-item">
                            <i class="bi bi-calendar-x"></i>
                            Selesai: {{ $end->format('d M Y') }}
                        </div>
                    </div>
                    <p style="margin: 0 0 0.5rem 0; color: var(--text-muted);">
                        Durasi: <strong>{{ $duration }} hari</strong>
                    </p>
                    <p style="margin: 0; color: var(--text-muted);">
                        Total Harga: <strong class="text-success">Rp {{ number_format($booking->total_harga, 0, ',', '.') }}</strong>
                    </p>
                    <div style="margin-top: 1rem;">
                        <span class="status-badge {{ $booking->status }}">
                            @switch($booking->status)
                                @case('pending')
                                    <i class="bi bi-clock"></i>
                                    @break
                                @case('dibatalkan')
                                    <i class="bi bi-x-circle"></i>
                                    @break
                                @case('aktif')
                                    <i class="bi bi-house-check"></i>
                                    @break
                                @case('selesai')
                                    <i class="bi bi-check-all"></i>
                                    @break
                            @endswitch
                            {{ ucfirst($booking->status) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @vite(['resources/js/app.js'])

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        mobileMenuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebarOverlay.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebar.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        // Close sidebar when clicking menu items on mobile
        if (window.innerWidth <= 768) {
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    if (!this.closest('form')) {
                        toggleSidebar();
                    }
                });
            });
        }
    </script>
</body>

</html>
