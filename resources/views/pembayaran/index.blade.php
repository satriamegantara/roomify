@extends('layouts.app')

@section('title', 'Riwayat Pembayaran - Roomify')

@section('content')
    <div class="pembayaran-header mb-4">
        <div class="d-flex align-items-center justify-content-between">
            <div>
                <h1 class="h3 fw-bold mb-1">Riwayat Pembayaran</h1>
                <p class="text-muted mb-0">Kelola dan pantau semua pembayaran kos Anda</p>
            </div>
            <div>
                <span class="badge bg-primary rounded-pill fs-6">
                    <i class="bi bi-calendar-check me-2"></i>{{ auth()->user()->pembayarans()->count() }} Pembayaran
                </span>
            </div>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="row g-4 mb-5">
        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon pending">
                    <i class="bi bi-hourglass-split"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Menunggu Verifikasi</h6>
                    <h3 class="stat-value">{{ auth()->user()->pembayarans()->where('status', 'pending')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon lunas">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Sudah Lunas</h6>
                    <h3 class="stat-value">{{ auth()->user()->pembayarans()->where('status', 'lunas')->count() }}</h3>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card">
                <div class="stat-icon terlambat">
                    <i class="bi bi-exclamation-triangle"></i>
                </div>
                <div class="stat-content">
                    <h6 class="stat-label">Terlambat</h6>
                    <h3 class="stat-value">{{ auth()->user()->pembayarans()->where('status', 'terlambat')->count() }}</h3>
                </div>
            </div>
        </div>
    </div>

    <!-- Alerts -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <!-- Filter -->
    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form action="{{ route('pembayaran.index') }}" method="GET" class="row g-3 align-items-end">
                <div class="col-md-6">
                    <label class="form-label">Filter Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua Status</option>
                        <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Menunggu Verifikasi
                        </option>
                        <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Sudah Lunas</option>
                        <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                    </select>
                </div>

                <div class="col-md-6">
                    <button type="submit" class="btn btn-primary">
                        <i class="bi bi-funnel me-2"></i>Filter
                    </button>
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-secondary">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <!-- Pembayaran List -->
    @if ($pembayarans->count() > 0)
        <div class="pembayaran-list">
            @foreach ($pembayarans as $pembayaran)
                <div class="pembayaran-item card shadow-sm border-0 mb-3">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <!-- Status Badge -->
                            <div class="col-auto">
                                <div class="status-badge status-{{ $pembayaran->status }}">
                                    @if ($pembayaran->status === 'pending')
                                        <i class="bi bi-hourglass-split"></i>
                                    @elseif ($pembayaran->status === 'lunas')
                                        <i class="bi bi-check-circle-fill"></i>
                                    @else
                                        <i class="bi bi-exclamation-triangle-fill"></i>
                                    @endif
                                </div>
                            </div>

                            <!-- Kos Info -->
                            <div class="col">
                                <h6 class="fw-bold mb-2">{{ $pembayaran->kos->nama }}</h6>
                                <small class="text-muted">
                                    <i class="bi bi-calendar3 me-1"></i>
                                    {{ $pembayaran->bulan_tahun->format('F Y') }}
                                </small>
                            </div>

                            <!-- Amount -->
                            <div class="col-auto text-end">
                                <h6 class="fw-bold text-primary mb-2">
                                    Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                </h6>
                                <small class="text-muted">
                                    <span class="badge bg-light text-dark">
                                        @if ($pembayaran->metode === 'transfer')
                                            <i class="bi bi-bank"></i> Transfer Bank
                                        @elseif ($pembayaran->metode === 'tunai')
                                            <i class="bi bi-cash-coin"></i> Tunai
                                        @else
                                            <i class="bi bi-phone"></i> E-Wallet
                                        @endif
                                    </span>
                                </small>
                            </div>

                            <!-- Action -->
                            <div class="col-auto">
                                <a href="{{ route('pembayaran.show', $pembayaran) }}" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye me-1"></i>Detail
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $pembayarans->links() }}
            </div>
        </div>
    @else
        <div class="empty-state text-center py-5">
            <div class="empty-icon mb-3">
                <i class="bi bi-inbox"></i>
            </div>
            <h5 class="fw-bold mb-2">Belum Ada Pembayaran</h5>
            <p class="text-muted mb-0">Anda belum memiliki riwayat pembayaran. Mulai dengan melakukan booking kos terlebih
                dahulu.</p>
        </div>
    @endif

    <style>
        /* Pembayaran Page Styles */
        .pembayaran-header {
            padding: 2rem 0;
            border-bottom: 2px solid #f3f4f6;
        }

        /* Stat Cards */
        .stat-card {
            background: white;
            border-radius: 12px;
            padding: 1.5rem;
            display: flex;
            gap: 1.5rem;
            align-items: flex-start;
            border: 1px solid #e5e7eb;
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            transform: translateY(-5px);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.75rem;
            color: white;
            flex-shrink: 0;
        }

        .stat-icon.pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .stat-icon.lunas {
            background: linear-gradient(135deg, #10a37f 0%, #059669 100%);
        }

        .stat-icon.terlambat {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        .stat-label {
            color: #6b7280;
            margin-bottom: 0.5rem;
            font-size: 0.85rem;
        }

        .stat-value {
            color: #1f2937;
            margin: 0;
            font-size: 2rem;
            font-weight: 800;
        }

        /* Pembayaran Item */
        .pembayaran-item {
            transition: all 0.3s ease;
            border-left: 4px solid transparent !important;
        }

        .pembayaran-item:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15) !important;
        }

        .status-badge {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: white;
        }

        .status-badge.status-pending {
            background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
        }

        .status-badge.status-lunas {
            background: linear-gradient(135deg, #10a37f 0%, #059669 100%);
        }

        .status-badge.status-terlambat {
            background: linear-gradient(135deg, #ef4444 0%, #dc2626 100%);
        }

        /* Empty State */
        .empty-state {
            padding: 3rem 2rem;
            border-radius: 12px;
            background: #f9fafb;
            border: 2px dashed #e5e7eb;
        }

        .empty-icon {
            font-size: 4rem;
            color: #d1d5db;
        }

        /* Status Badge Colors */
        .badge.bg-light {
            background-color: #f3f4f6 !important;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .pembayaran-header {
                padding: 1rem 0;
            }

            .pembayaran-item .row {
                flex-direction: column;
                gap: 1rem;
            }

            .pembayaran-item .col,
            .pembayaran-item .col-auto {
                width: 100%;
            }

            .pembayaran-item .col-auto.text-end {
                text-align: left !important;
            }

            .stat-card {
                flex-direction: column;
                text-align: center;
            }

            .stat-label {
                color: #6b7280;
            }
        }
    </style>
@endsection