<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Booking Masuk - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-booking.css'])
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
            <img src="{{ asset('assets/images/test.png') }}" alt="Roomify Logo" height="40" class="me-2 logo-img"><span>Roomify</span>
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
        <!-- Success Message -->
        @if (session('success'))
            <div class="alert alert-success" style="margin-bottom: 1.5rem; padding: 1rem 1.5rem; background: #d1fae5; border: 1px solid #10b981; border-radius: 8px; color: #065f46; display: flex; align-items: center; gap: 0.75rem;">
                <i class="bi bi-check-circle-fill" style="font-size: 1.25rem;"></i>
                <span style="font-weight: 500;">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Header -->
        <div class="booking-header">
            <div class="booking-header-top">
                <div>
                    <h1 class="booking-title">
                        <i class="bi bi-calendar-check me-2"></i>Booking Masuk
                    </h1>
                    <p class="booking-subtitle">Kelola semua booking yang masuk untuk properti kos Anda</p>
                </div>
            </div>
        </div>

        <!-- Statistics Cards -->
        <div class="booking-stats">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-event"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $bookings->total() }}</div>
                <div class="stat-label">Total Booking</div>
            </div>

            <div class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $bookings->where('status', 'pending')->count() }}</div>
                <div class="stat-label">Menunggu Persetujuan</div>
            </div>

            <div class="stat-card active">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-house-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $bookings->where('status', 'aktif')->count() }}</div>
                <div class="stat-label">Sedang Aktif</div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $bookings->where('status', 'selesai')->count() }}</div>
                <div class="stat-label">Selesai</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="booking-filters">
            <form action="{{ route('pemilik.bookings.index') }}" method="GET">
                <div class="filters-row">
                    <div class="filter-group">
                        <label class="filter-label">Status Booking</label>
                        <select name="status" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="dibatalkan" {{ request('status') == 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                            <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Aktif</option>
                            <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                        </select>
                    </div>

                    <div class="filter-group">
                        <label class="filter-label">Cari Penyewa</label>
                        <input type="text" name="search" class="filter-input" placeholder="Nama penyewa..."
                            value="{{ request('search') }}">
                    </div>

                    <button type="submit" class="filter-btn">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                </div>
            </form>
        </div>

        <!-- Booking Table -->
        <div class="booking-table-container">
            <div class="table-header">
                <h3 class="table-title">Daftar Booking</h3>
            </div>

            @if ($bookings->count() > 0)
                <table class="booking-table">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Properti Kos</th>
                            <th>Tanggal Booking</th>
                            <th>Durasi</th>
                            <th>Total Harga</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($bookings as $booking)
                            <tr>
                                <!-- Penyewa Info -->
                                <td>
                                    <div class="booking-info">
                                        <div class="booking-avatar">
                                            {{ strtoupper(substr($booking->penyewa->name, 0, 1)) }}
                                        </div>
                                        <div class="booking-details">
                                            <h4>{{ $booking->penyewa->name }}</h4>
                                            <p><i class="bi bi-envelope me-1"></i>{{ $booking->penyewa->email }}</p>
                                        </div>
                                    </div>
                                </td>

                                <!-- Kos Info -->
                                <td>
                                    <div class="kos-name">{{ Str::limit($booking->kos->alamat, 30) }}</div>
                                    <div class="kos-address">
                                        <i class="bi bi-geo-alt"></i>
                                        <span>{{ Str::limit($booking->kos->alamat, 40) }}</span>
                                    </div>
                                </td>

                                <!-- Dates -->
                                <td>
                                    <div class="booking-dates">
                                        <div class="date-item">
                                            <i class="bi bi-calendar-check"></i>
                                            {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M Y') }}
                                        </div>
                                        <div class="date-item">
                                            <i class="bi bi-calendar-x"></i>
                                            {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                                        </div>
                                    </div>
                                </td>

                                <!-- Duration -->
                                <td>
                                    @php
                                        $start = \Carbon\Carbon::parse($booking->tanggal_mulai);
                                        $end = \Carbon\Carbon::parse($booking->tanggal_selesai);
                                        // Pastikan minimal 1 hari dan hindari output bilangan pecahan
                                        $duration = max(1, $start->diffInDays($end) ?: 1);
                                    @endphp
                                    <strong>{{ $duration }} hari</strong>
                                </td>

                                <!-- Price -->
                                <td>
                                    <div class="booking-price">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </div>
                                </td>

                                <!-- Status -->
                                <td>
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
                                </td>

                                <!-- Actions -->
                                <td>
                                    <div class="booking-actions">
                                        <a href="{{ route('pemilik.bookings.show', $booking) }}" class="action-btn view" title="Lihat Detail">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        @if ($booking->status == 'pending')
                                            <form action="{{ route('pemilik.bookings.approve', $booking) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="action-btn approve" title="Setujui"
                                                    onclick="return confirm('Setujui booking ini?')">
                                                    <i class="bi bi-check-lg"></i>
                                                </button>
                                            </form>

                                            <form action="{{ route('pemilik.bookings.reject', $booking) }}" method="POST" style="display: inline;">
                                                @csrf
                                                <button type="submit" class="action-btn reject" title="Tolak"
                                                    onclick="return confirm('Tolak booking ini?')">
                                                    <i class="bi bi-x-lg"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="booking-pagination">
                    {{ $bookings->links() }}
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-calendar-x"></i>
                    </div>
                    <h3 class="empty-title">Belum Ada Booking</h3>
                    <p class="empty-text">Booking akan muncul di sini ketika ada penyewa yang tertarik dengan properti kos
                        Anda.</p>
                </div>
            @endif
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

        mobileMenuToggle.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebarOverlay.addEventListener('click', function(e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebar.addEventListener('click', function(e) {
            e.stopPropagation();
        });

        // Close sidebar when clicking menu items on mobile
        if (window.innerWidth <= 768) {
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function(e) {
                    if (!this.closest('form')) {
                        toggleSidebar();
                    }
                });
            });
        }

        // Auto-hide success messages
        @if(session('success'))
            setTimeout(() => {
                const alert = document.querySelector('.alert-success');
                if (alert) {
                    alert.style.transition = 'opacity 0.3s ease';
                    alert.style.opacity = '0';
                    setTimeout(() => alert.remove(), 300);
                }
            }, 5000);
        @endif
    </script>
</body>

</html>
