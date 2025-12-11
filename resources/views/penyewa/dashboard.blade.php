@extends('layouts.app')

@push('styles')
    @vite('resources/css/penyewa-dashboard.css')
@endpush

@section('title', 'Dashboard Penyewa')

@section('content')
    <div class="penyewa-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="header-title">
                <i class="bi bi-house-heart"></i>Selamat Datang, {{ $user->name }}!
            </h1>
            <p class="header-subtitle">Kelola booking dan pembayaran kos Anda dengan mudah.</p>
        </div>

        <!-- Stats Grid -->
        <div class="stats-grid">
            <div class="stat-card active">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-house-check"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $activeBookings }}</div>
                <div class="stat-label">Booking Aktif</div>
            </div>

            <div class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-clock-history"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $pendingBookings }}</div>
                <div class="stat-label">Menunggu Konfirmasi</div>
            </div>

            <div class="stat-card completed">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-check2-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $completedBookings }}</div>
                <div class="stat-label">Selesai</div>
            </div>

            <div class="stat-card paid">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-credit-card"></i>
                    </div>
                </div>
                <div class="stat-value">Rp {{ number_format($totalPaid, 0, ',', '.') }}</div>
                <div class="stat-label">Sudah Dibayar</div>
            </div>

            <div class="stat-card overdue">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-exclamation-circle"></i>
                    </div>
                </div>
                <div class="stat-value">{{ $latePayments }}</div>
                <div class="stat-label">Pembayaran Terlambat</div>
            </div>

            <div class="stat-card pending">
                <div class="stat-header">
                    <div class="stat-icon">
                        <i class="bi bi-hourglass-split"></i>
                    </div>
                </div>
                <div class="stat-value">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</div>
                <div class="stat-label">Menunggu Pembayaran</div>
            </div>
        </div>

        <!-- Booking Section -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-calendar-check"></i>Booking Saya
                </h2>
                <a href="{{ route('booking.index') }}" class="view-all-btn">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="list-container">
                @if ($myBookings->count() > 0)
                    @foreach ($myBookings->take(5) as $booking)
                        <div class="list-item">
                            <div class="list-item-info">
                                <div class="list-item-title">{{ $booking->kos->alamat }}</div>
                                <div class="list-item-subtitle">
                                    <i class="bi bi-geo-alt"></i>
                                    {{ Str::limit($booking->kos->alamat, 50) }}
                                </div>
                            </div>

                            <div class="list-item-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Periode</span>
                                    <span class="meta-value">
                                        {{ \Carbon\Carbon::parse($booking->tanggal_mulai)->format('d M') }} -
                                        {{ \Carbon\Carbon::parse($booking->tanggal_selesai)->format('d M Y') }}
                                    </span>
                                </div>

                                <div class="meta-item">
                                    <span class="meta-label">Harga</span>
                                    <span class="meta-value amount">
                                        Rp {{ number_format($booking->total_harga, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="meta-item">
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
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-calendar-x"></i>
                        </div>
                        <h3 class="empty-title">Belum Ada Booking</h3>
                        <p class="empty-text">Mulai cari kos favorit Anda dan lakukan booking sekarang!</p>
                        <a href="{{ route('kos.index') }}" class="btn-primary-kosan" style="margin-top: 1.5rem;">
                            <i class="bi bi-search"></i>Cari Kos
                        </a>
                    </div>
                @endif
            </div>
        </div>

        <!-- Payment Section -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-cash-stack"></i>Riwayat Pembayaran
                </h2>
                <a href="{{ route('pembayaran.index') }}" class="view-all-btn">
                    Lihat Semua <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="list-container">
                @if ($myPayments->count() > 0)
                    @foreach ($myPayments->take(5) as $payment)
                        <div class="list-item">
                            <div class="list-item-info">
                                <div class="list-item-title">{{ $payment->kos->alamat }}</div>
                                <div class="list-item-subtitle">
                                    <i class="bi bi-calendar"></i>
                                    Periode: {{ \Carbon\Carbon::parse($payment->bulan_tahun)->translatedFormat('F Y') }}
                                </div>
                            </div>

                            <div class="list-item-meta">
                                <div class="meta-item">
                                    <span class="meta-label">Metode</span>
                                    <span class="meta-value">
                                        {{ ucfirst(str_replace('_', ' ', $payment->metode)) }}
                                    </span>
                                </div>

                                <div class="meta-item">
                                    <span class="meta-label">Jumlah</span>
                                    <span class="meta-value amount {{ $payment->status === 'terlambat' ? 'overdue' : '' }}">
                                        Rp {{ number_format($payment->jumlah, 0, ',', '.') }}
                                    </span>
                                </div>

                                <div class="meta-item">
                                    <span class="status-badge {{ $payment->status }}">
                                        @switch($payment->status)
                                            @case('pending')
                                                <i class="bi bi-clock"></i>
                                                @break
                                            @case('lunas')
                                                <i class="bi bi-check2-circle"></i>
                                                @break
                                            @case('terlambat')
                                                <i class="bi bi-exclamation-octagon"></i>
                                                @break
                                        @endswitch
                                        {{ ucfirst($payment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @endforeach
                @else
                    <div class="empty-state">
                        <div class="empty-icon">
                            <i class="bi bi-wallet2"></i>
                        </div>
                        <h3 class="empty-title">Belum Ada Pembayaran</h3>
                        <p class="empty-text">Riwayat pembayaran Anda akan muncul di sini setelah melakukan booking.</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="section-container">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="bi bi-lightning-fill"></i>Akses Cepat
                </h2>
            </div>

            <div class="list-container" style="display: flex; gap: 1rem; flex-wrap: wrap; padding: 1.5rem;">
                <a href="{{ route('kos.index') }}" class="btn-primary-kosan">
                    <i class="bi bi-search"></i>Cari Kos Baru
                </a>
                <a href="{{ route('booking.index') }}" class="btn-primary-kosan" style="background: #3b82f6;">
                    <i class="bi bi-calendar-check"></i>Kelola Booking
                </a>
                <a href="{{ route('profile.edit') }}" class="btn-primary-kosan" style="background: #6366f1;">
                    <i class="bi bi-person-circle"></i>Edit Profil
                </a>
                <a href="{{ route('chat.index') }}" class="btn-primary-kosan" style="background: #ec4899;">
                    <i class="bi bi-chat-dots"></i>Pesan
                </a>
            </div>
        </div>
    </div>
@endsection
