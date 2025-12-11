@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin-dashboard.css')
@endpush

@section('title', 'Admin Dashboard')

@section('content')
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="header-title">
                <i class="bi bi-speedometer2"></i>Dashboard Admin
            </h1>
            <p class="header-subtitle">Kelola dan pantau semua aktivitas platform Roomify</p>
        </div>

        <!-- Management Buttons -->
        <div class="management-buttons" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-bottom: 30px;">
            <a href="{{ route('admin.users.index') }}" class="management-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s, box-shadow 0.2s;">
                <i class="bi bi-person-check" style="font-size: 1.5rem;"></i>
                <span>Verifikasi User</span>
            </a>
            <a href="{{ route('admin.kos.index') }}" class="management-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px; background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s, box-shadow 0.2s;">
                <i class="bi bi-house-check" style="font-size: 1.5rem;"></i>
                <span>Verifikasi Kos</span>
            </a>
            <a href="{{ route('admin.pembayaran.index') }}" class="management-btn" style="display: flex; align-items: center; justify-content: center; gap: 10px; padding: 15px 20px; background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: 600; transition: transform 0.2s, box-shadow 0.2s;">
                <i class="bi bi-cash-stack" style="font-size: 1.5rem;"></i>
                <span>Manajemen Pembayaran</span>
            </a>
        </div>

        <style>
            .management-btn:hover {
                transform: translateY(-2px);
                box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
            }
        </style>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <!-- Users Section -->
            <div class="stat-card users">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
            </div>

            <div class="stat-card pemilik">
                <div class="stat-icon">
                    <i class="bi bi-building"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pemiliks }}</div>
                    <div class="stat-label">Pemilik Kos</div>
                </div>
            </div>

            <div class="stat-card penyewa">
                <div class="stat-icon">
                    <i class="bi bi-person-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $penyewas }}</div>
                    <div class="stat-label">Penyewa</div>
                </div>
            </div>

            <div class="stat-card admin">
                <div class="stat-icon">
                    <i class="bi bi-shield-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $admins }}</div>
                    <div class="stat-label">Admin</div>
                </div>
            </div>

            <div class="stat-card unverified">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $unverifiedUsers }}</div>
                    <div class="stat-label">User Menunggu Verifikasi</div>
                </div>
            </div>

            <!-- Kos Section -->
            <div class="stat-card kos">
                <div class="stat-icon">
                    <i class="bi bi-house"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalKos }}</div>
                    <div class="stat-label">Total Kos</div>
                </div>
            </div>

            <div class="stat-card verified">
                <div class="stat-icon">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $verifiedKos }}</div>
                    <div class="stat-label">Terverifikasi</div>
                </div>
            </div>

            <div class="stat-card unverified">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $unverifiedKos }}</div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
            </div>

            <div class="stat-card active">
                <div class="stat-icon">
                    <i class="bi bi-lightning-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $aktifKos }}</div>
                    <div class="stat-label">Kos Aktif</div>
                </div>
            </div>

            <!-- Booking Section -->
            <div class="stat-card bookings">
                <div class="stat-icon">
                    <i class="bi bi-calendar-check"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalBookings }}</div>
                    <div class="stat-label">Total Booking</div>
                </div>
            </div>

            <div class="stat-card pending">
                <div class="stat-icon">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $pendingBookings }}</div>
                    <div class="stat-label">Pending</div>
                </div>
            </div>

            <div class="stat-card status-aktif">
                <div class="stat-icon">
                    <i class="bi bi-check2-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $aktifBookings }}</div>
                    <div class="stat-label">Aktif</div>
                </div>
            </div>

            <div class="stat-card completed">
                <div class="stat-icon">
                    <i class="bi bi-check-all"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $selesaiBookings }}</div>
                    <div class="stat-label">Selesai</div>
                </div>
            </div>

            <!-- Payment Section -->
            <div class="stat-card payment">
                <div class="stat-icon">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalPembayaran }}</div>
                    <div class="stat-label">Total Pembayaran</div>
                </div>
            </div>

            <div class="stat-card lunas">
                <div class="stat-icon">
                    <i class="bi bi-credit-card"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($totalLunasAmount, 0, ',', '.') }}</div>
                    <div class="stat-label">Sudah Terbayar</div>
                </div>
            </div>

            <div class="stat-card overdue">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-octagon"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $latePayments }}</div>
                    <div class="stat-label">Terlambat</div>
                </div>
            </div>

            <!-- Review Section -->
            <div class="stat-card review">
                <div class="stat-icon">
                    <i class="bi bi-star-fill"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ number_format($avgRating, 1) }}/5</div>
                    <div class="stat-label">Rating Rata-rata</div>
                </div>
            </div>

            <div class="stat-card review-count">
                <div class="stat-icon">
                    <i class="bi bi-chat-left-quote"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalReviews }}</div>
                    <div class="stat-label">Total Review</div>
                </div>
            </div>
        </div>

        <!-- Recent Data Sections -->
        <div class="recent-sections">
            <!-- Recent Kos -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-house-exclamation"></i>Kos Terbaru
                    </h2>
                    <a href="{{ route('admin.kos.index') }}" class="view-all-btn">
                        Kelola Kos <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="list-container">
                    @forelse ($recentKos as $kos)
                        <div class="list-item">
                            @if ($kos->foto_utama)
                                <img src="{{ asset('storage/' . $kos->foto_utama) }}" alt="{{ $kos->alamat }}" class="item-image">
                            @else
                                <div class="item-image placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <div class="item-info">
                                <div class="item-title">{{ $kos->alamat }}</div>
                                <div class="item-meta">
                                    <span class="meta-label">Pemilik:</span>
                                    <span class="meta-value">{{ $kos->pemilik->name }}</span>
                                </div>
                            </div>

                            <div class="item-status">
                                @if ($kos->verified_at)
                                    <span class="badge verified">
                                        <i class="bi bi-check-circle"></i>Terverifikasi
                                    </span>
                                @else
                                    <span class="badge unverified">
                                        <i class="bi bi-exclamation-circle"></i>Menunggu
                                    </span>
                                @endif
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <p>Belum ada kos</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Recent Bookings -->
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="bi bi-calendar2-check"></i>Booking Terbaru
                    </h2>
                    <a href="{{ route('pemilik.bookings.index') }}" class="view-all-btn">
                        Lihat Semua <i class="bi bi-arrow-right"></i>
                    </a>
                </div>

                <div class="list-container">
                    @forelse ($recentBookings as $booking)
                        <div class="list-item">
                            <div class="item-avatar">
                                <img src="https://ui-avatars.com/api/?name={{ urlencode($booking->penyewa->name) }}&background=10a37f&color=fff"
                                    alt="{{ $booking->penyewa->name }}">
                            </div>

                            <div class="item-info">
                                <div class="item-title">{{ $booking->penyewa->name }}</div>
                                <div class="item-meta">
                                    <span class="meta-label">Kos:</span>
                                    <span class="meta-value">{{ Str::limit($booking->kos->alamat, 30) }}</span>
                                </div>
                            </div>

                            <div class="item-status">
                                <span class="status-badge {{ $booking->status }}">
                                    @switch($booking->status)
                                        @case('pending')
                                            <i class="bi bi-clock"></i>
                                            @break
                                        @case('aktif')
                                            <i class="bi bi-house-check"></i>
                                            @break
                                        @case('selesai')
                                            <i class="bi bi-check-all"></i>
                                            @break
                                        @case('dibatalkan')
                                            <i class="bi bi-x-circle"></i>
                                            @break
                                    @endswitch
                                    {{ ucfirst($booking->status) }}
                                </span>
                            </div>
                        </div>
                    @empty
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-inbox"></i>
                            </div>
                            <p>Belum ada booking</p>
                        </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
