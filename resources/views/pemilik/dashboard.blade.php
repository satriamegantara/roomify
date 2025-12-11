<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Dashboard Pemilik - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
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
                <a href="{{ route('pemilik.dashboard') }}"
                    class="{{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.kos.index') }}"
                    class="{{ request()->routeIs('pemilik.kos.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Kelola Kos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.bookings.index') }}"
                    class="{{ request()->routeIs('pemilik.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.pembayaran.index') }}"
                    class="{{ request()->routeIs('pemilik.pembayaran.*') ? 'active' : '' }}">
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
    <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="top-bar-title">
                <h1>Dashboard Pemilik</h1>
                <p>Kelola kos dan monitoring aktivitas bisnis Anda</p>
            </div>
            <div class="top-bar-user">
                <div class="user-info">
                    <div class="name">{{ Auth::user()->name }}</div>
                    <div class="role">Pemilik Kos</div>
                </div>
                <div class="user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-icon primary">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Kos</h3>
                    <div class="value">{{ $totalKos }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon secondary">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Booking</h3>
                    <div class="value">{{ $totalBookings }}</div>
                    <div class="trend up">
                        <i class="bi bi-arrow-up"></i> {{ $activeBookings }} aktif
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon warning">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-info">
                    <h3>Menunggu Konfirmasi</h3>
                    <div class="value">{{ $pendingBookings }}</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon success">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Pendapatan</h3>
                    <div class="value">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</div>
                    @if($pendingPayments > 0)
                        <div class="trend">
                            <i class="bi bi-clock"></i> {{ $pendingPayments }} pending
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Content Grid -->
        <div class="content-grid">
            <!-- Recent Bookings -->
            <div class="card">
                <div class="card-header">
                    <h2>Booking Terbaru</h2>
                    <a href="{{ route('pemilik.bookings.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    @if($recentBookings->count() > 0)
                        <div class="table-responsive">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Penyewa</th>
                                        <th>Kos</th>
                                        <th>Tanggal</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($recentBookings as $booking)
                                        <tr>
                                            <td>
                                                <strong>{{ $booking->penyewa->name }}</strong><br>
                                                <small class="text-muted">{{ $booking->penyewa->email }}</small>
                                            </td>
                                            <td>{{ $booking->kos->nama }}</td>
                                            <td>{{ $booking->tanggal_kunjungan ? $booking->tanggal_kunjungan->format('d M Y') : '-' }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $booking->status }}">
                                                    {{ ucfirst($booking->status) }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4" style="color: #6b7280;">
                            <i class="bi bi-inbox" style="font-size: 3rem; opacity: 0.3;"></i>
                            <p class="mt-2">Belum ada booking</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Stats -->
            <div class="card">
                <div class="card-header">
                    <h2>Statistik Cepat</h2>
                </div>
                <div class="card-body">
                    <ul class="quick-stats">
                        <li>
                            <span class="label">Pembayaran Terverifikasi</span>
                            <span class="value" style="color: var(--success);">
                                Rp {{ number_format($totalRevenue, 0, ',', '.') }}
                            </span>
                        </li>
                        <li>
                            <span class="label">Pembayaran Pending</span>
                            <span class="value" style="color: var(--warning);">
                                {{ $pendingPayments }}
                            </span>
                        </li>
                        <li>
                            <span class="label">Booking Aktif</span>
                            <span class="value" style="color: var(--primary);">
                                {{ $activeBookings }}
                            </span>
                        </li>
                        <li>
                            <span class="label">Menunggu Konfirmasi</span>
                            <span class="value" style="color: var(--secondary);">
                                {{ $pendingBookings }}
                            </span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <!-- Recent Payments -->
        @if($pembayarans->count() > 0)
            <div class="card" style="margin-top: 1.5rem;">
                <div class="card-header">
                    <h2>Riwayat Pembayaran Terbaru</h2>
                    <a href="{{ route('pemilik.pembayaran.index') }}" class="btn btn-primary btn-sm">
                        Lihat Semua
                    </a>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th>Tanggal</th>
                                    <th>Penyewa</th>
                                    <th>Kos</th>
                                    <th>Jumlah</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($pembayarans->take(5) as $pembayaran)
                                    <tr>
                                        <td>{{ $pembayaran->created_at->format('d M Y') }}</td>
                                        <td>{{ $pembayaran->penyewa->name }}</td>
                                        <td>{{ $pembayaran->kos->nama }}</td>
                                        <td><strong>Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</strong></td>
                                        <td>
                                            <span class="badge {{ $pembayaran->status }}">
                                                {{ ucfirst($pembayaran->status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        @endif
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

        mobileMenuToggle.addEventListener('click', toggleSidebar);
        sidebarOverlay.addEventListener('click', toggleSidebar);

        // Close sidebar when clicking menu items on mobile
        if (window.innerWidth <= 768) {
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function (e) {
                    // Don't close if it's the logout link (let form submit)
                    if (!this.closest('form')) {
                        toggleSidebar();
                    }
                });
            });
        }
    </script>
</body>

</html>