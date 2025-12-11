@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin-dashboard.css')
@endpush

@section('title', 'Detail Pembayaran')

@section('content')
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="header-title">
                <i class="bi bi-receipt"></i>Detail Pembayaran
            </h1>
            <p class="header-subtitle">Informasi lengkap transaksi pembayaran</p>
        </div>

        <div class="detail-container">
            <!-- Status Card -->
            <div class="status-card" style="
                background: linear-gradient(135deg, 
                    @switch($pembayaran->status)
                        @case('pending') #fff3cd @break
                        @case('lunas') #d4edda @break
                        @case('terlambat') #f8d7da @break
                    @endswitch
                    0%, 
                    @switch($pembayaran->status)
                        @case('pending') #ffe8a8 @break
                        @case('lunas') #c3e6cb @break
                        @case('terlambat') #f5c6cb @break
                    @endswitch
                    100%);
                padding: 30px;
                border-radius: 12px;
                margin-bottom: 30px;
                color: 
                @switch($pembayaran->status)
                    @case('pending') #856404 @break
                    @case('lunas') #155724 @break
                    @case('terlambat') #721c24 @break
                @endswitch
            ">
                <div style="display: flex; align-items: center; justify-content: space-between;">
                    <div>
                        <div style="font-size: 14px; opacity: 0.8; margin-bottom: 10px;">Status Pembayaran</div>
                        <div style="font-size: 28px; font-weight: 700;">
                            @switch($pembayaran->status)
                                @case('pending')
                                    <i class="bi bi-clock"></i> Menunggu Pembayaran
                                    @break
                                @case('lunas')
                                    <i class="bi bi-check-circle"></i> Sudah Terbayar
                                    @break
                                @case('terlambat')
                                    <i class="bi bi-exclamation-circle"></i> Terlambat
                                    @break
                            @endswitch
                        </div>
                    </div>
                    <div style="font-size: 48px; opacity: 0.3;">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                </div>
            </div>

            <!-- Two Column Layout -->
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 30px; margin-bottom: 30px;">
                <!-- Left Column: Payment Info -->
                <div class="info-card">
                    <h3 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                        <i class="bi bi-info-circle"></i> Informasi Pembayaran
                    </h3>

                    <div class="info-row">
                        <span class="info-label">ID Pembayaran</span>
                        <span class="info-value">{{ $pembayaran->id }}</span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Jumlah Pembayaran</span>
                        <span class="info-value" style="font-size: 20px; color: #10a37f; font-weight: 700;">
                            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Metode Pembayaran</span>
                        <span class="info-value">
                            @switch($pembayaran->metode_pembayaran)
                                @case('transfer')
                                    <i class="bi bi-bank"></i> Transfer Bank
                                    @break
                                @case('kartu_kredit')
                                    <i class="bi bi-credit-card"></i> Kartu Kredit
                                    @break
                                @case('e_wallet')
                                    <i class="bi bi-wallet2"></i> E-Wallet
                                    @break
                            @endswitch
                        </span>
                    </div>

                    <div class="info-row">
                        <span class="info-label">Tanggal Pembayaran</span>
                        <span class="info-value">{{ $pembayaran->created_at->format('d F Y H:i:s') }}</span>
                    </div>

                    @if($pembayaran->updated_at && $pembayaran->updated_at !== $pembayaran->created_at)
                        <div class="info-row">
                            <span class="info-label">Terakhir Update</span>
                            <span class="info-value">{{ $pembayaran->updated_at->format('d F Y H:i:s') }}</span>
                        </div>
                    @endif

                    @if($pembayaran->bukti_pembayaran)
                        <div class="info-row">
                            <span class="info-label">Bukti Pembayaran</span>
                            <span class="info-value">
                                <a href="{{ asset('storage/' . $pembayaran->bukti_pembayaran) }}" target="_blank" class="btn btn-sm btn-primary">
                                    <i class="bi bi-download"></i> Lihat Bukti
                                </a>
                            </span>
                        </div>
                    @endif
                </div>

                <!-- Right Column: Penyewa & Kos Info -->
                <div>
                    <!-- Penyewa Info -->
                    <div class="info-card">
                        <h3 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <i class="bi bi-person"></i> Informasi Penyewa
                        </h3>

                        <div style="display: flex; align-items: center; gap: 15px; margin-bottom: 20px;">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pembayaran->booking->penyewa->name) }}&background=10a37f&color=fff"
                                alt="{{ $pembayaran->booking->penyewa->name }}" style="width: 50px; height: 50px; border-radius: 50%;">
                            <div>
                                <div style="font-weight: 700; font-size: 16px;">{{ $pembayaran->booking->penyewa->name }}</div>
                                <div style="color: #999; font-size: 13px;">{{ $pembayaran->booking->penyewa->email }}</div>
                            </div>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Role</span>
                            <span class="info-value">
                                @if($pembayaran->booking->penyewa->role === 'penyewa')
                                    <span class="badge" style="background-color: #e3f2fd; color: #1976d2;">Penyewa</span>
                                @endif
                            </span>
                        </div>
                    </div>

                    <!-- Kos Info -->
                    <div class="info-card" style="margin-top: 20px;">
                        <h3 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                            <i class="bi bi-house"></i> Informasi Kos
                        </h3>

                        <div class="info-row">
                            <span class="info-label">Nama Kos</span>
                            <span class="info-value" style="font-weight: 700;">{{ $pembayaran->booking->kos->nama_kos }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Alamat</span>
                            <span class="info-value">{{ $pembayaran->booking->kos->alamat }}</span>
                        </div>

                        <div class="info-row">
                            <span class="info-label">Booking ID</span>
                            <span class="info-value">
                                <a href="{{ route('pemilik.bookings.show', $pembayaran->booking) }}" class="btn btn-sm btn-primary">
                                    #{{ $pembayaran->booking->id }}
                                </a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Booking Details -->
            <div class="info-card">
                <h3 style="margin-top: 0; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 2px solid #f0f0f0;">
                    <i class="bi bi-calendar-event"></i> Detail Booking
                </h3>

                <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
                    <div>
                        <div class="info-label">Tanggal Check-in</div>
                        <div class="info-value" style="font-weight: 700; font-size: 16px;">
                            {{ \Carbon\Carbon::parse($pembayaran->booking->tanggal_check_in)->format('d F Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Tanggal Check-out</div>
                        <div class="info-value" style="font-weight: 700; font-size: 16px;">
                            {{ \Carbon\Carbon::parse($pembayaran->booking->tanggal_check_out)->format('d F Y') }}
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Total Hari</div>
                        <div class="info-value" style="font-weight: 700; font-size: 16px;">
                            {{ \Carbon\Carbon::parse($pembayaran->booking->tanggal_check_in)->diffInDays(\Carbon\Carbon::parse($pembayaran->booking->tanggal_check_out)) }} hari
                        </div>
                    </div>

                    <div>
                        <div class="info-label">Status Booking</div>
                        <div class="info-value">
                            <span class="badge" style="
                                @switch($pembayaran->booking->status)
                                    @case('pending')
                                        background-color: #fff3cd; color: #856404;
                                        @break
                                    @case('aktif')
                                        background-color: #d4edda; color: #155724;
                                        @break
                                    @case('selesai')
                                        background-color: #d1ecf1; color: #0c5460;
                                        @break
                                    @case('dibatalkan')
                                        background-color: #f8d7da; color: #721c24;
                                        @break
                                @endswitch
                            ">
                                {{ ucfirst($pembayaran->booking->status) }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Back Button -->
        <div class="mt-5">
            <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Daftar Pembayaran
            </a>
        </div>
    </div>

    <style>
        .detail-container {
            max-width: 1000px;
            margin: 0 auto;
        }

        .info-card {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .info-row {
            display: grid;
            grid-template-columns: 150px 1fr;
            gap: 20px;
            padding: 15px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .info-row:last-child {
            border-bottom: none;
        }

        .info-label {
            font-weight: 600;
            color: #666;
            font-size: 13px;
            text-transform: uppercase;
        }

        .info-value {
            color: #333;
            font-size: 14px;
            word-break: break-word;
        }

        .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }

        .btn-secondary {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 10px 20px;
            background-color: #6c757d;
            color: white;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        @media (max-width: 768px) {
            .info-row {
                grid-template-columns: 1fr;
                gap: 8px;
            }

            .detail-container {
                padding: 0;
            }
        }
    </style>
@endsection
