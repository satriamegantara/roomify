@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin-dashboard.css')
@endpush

@section('title', 'Manajemen Pembayaran')

@section('content')
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="header-title">
                <i class="bi bi-cash-stack"></i>Manajemen Pembayaran
            </h1>
            <p class="header-subtitle">Monitor dan kelola semua transaksi pembayaran di platform</p>
        </div>

        <!-- Stats Cards -->
        <div class="stats-grid" style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white;">
                    <i class="bi bi-cash-stack"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalPembayaran }}</div>
                    <div class="stat-label">Total Pembayaran</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); color: white;">
                    <i class="bi bi-currency-dollar"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($totalAmount, 0, ',', '.') }}</div>
                    <div class="stat-label">Total Nilai</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); color: white;">
                    <i class="bi bi-check-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $lunasCount }}</div>
                    <div class="stat-label">Sudah Terbayar</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); color: white;">
                    <i class="bi bi-cash-coin"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($lunasAmount, 0, ',', '.') }}</div>
                    <div class="stat-label">Nominal Terbayar</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #fa709a 0%, #fee140 100%); color: white;">
                    <i class="bi bi-clock"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">Rp {{ number_format($pendingAmount, 0, ',', '.') }}</div>
                    <div class="stat-label">Menunggu Pembayaran</div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-icon" style="background: linear-gradient(135deg, #ff6b6b 0%, #ff0844 100%); color: white;">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $lateCount }}</div>
                    <div class="stat-label">Terlambat</div>
                </div>
            </div>
        </div>

        <!-- Filter Section -->
        <div class="table-section" style="margin-bottom: 30px;">
            <div class="section-header">
                <h3 style="margin: 0; font-size: 1.3rem;">
                    <i class="bi bi-funnel"></i> Filter Pembayaran
                </h3>
            </div>

            <form method="GET" action="{{ route('admin.pembayaran.index') }}" class="filter-form">
                <div class="filter-grid">
                    <!-- Search Box -->
                    <div class="filter-group">
                        <label for="search" class="form-label">Cari Penyewa</label>
                        <input type="text" id="search" name="search" class="form-control" 
                            placeholder="Nama atau email penyewa" value="{{ request('search') }}">
                    </div>

                    <!-- Status Filter -->
                    <div class="filter-group">
                        <label for="status" class="form-label">Status Pembayaran</label>
                        <select id="status" name="status" class="form-select">
                            <option value="">-- Semua Status --</option>
                            <option value="pending" {{ request('status') === 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="lunas" {{ request('status') === 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="terlambat" {{ request('status') === 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>

                    <!-- Payment Method Filter -->
                    <div class="filter-group">
                        <label for="metode_pembayaran" class="form-label">Metode Pembayaran</label>
                        <select id="metode_pembayaran" name="metode_pembayaran" class="form-select">
                            <option value="">-- Semua Metode --</option>
                            <option value="transfer" {{ request('metode_pembayaran') === 'transfer' ? 'selected' : '' }}>Transfer Bank</option>
                            <option value="kartu_kredit" {{ request('metode_pembayaran') === 'kartu_kredit' ? 'selected' : '' }}>Kartu Kredit</option>
                            <option value="e_wallet" {{ request('metode_pembayaran') === 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>

                    <!-- Date From -->
                    <div class="filter-group">
                        <label for="date_from" class="form-label">Tanggal Mulai</label>
                        <input type="date" id="date_from" name="date_from" class="form-control" 
                            value="{{ request('date_from') }}">
                    </div>

                    <!-- Date To -->
                    <div class="filter-group">
                        <label for="date_to" class="form-label">Tanggal Akhir</label>
                        <input type="date" id="date_to" name="date_to" class="form-control" 
                            value="{{ request('date_to') }}">
                    </div>

                    <!-- Buttons -->
                    <div class="filter-group" style="display: flex; gap: 10px; align-items: flex-end;">
                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-search"></i> Filter
                        </button>
                        <a href="{{ route('admin.pembayaran.index') }}" class="btn btn-secondary">
                            <i class="bi bi-arrow-clockwise"></i> Reset
                        </a>
                    </div>
                </div>
            </form>

            <style>
                .filter-form {
                    padding: 20px;
                    background: #f8f9fa;
                    border-radius: 8px;
                }

                .filter-grid {
                    display: grid;
                    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
                    gap: 15px;
                }

                .filter-group {
                    display: flex;
                    flex-direction: column;
                }

                .filter-group label {
                    font-weight: 600;
                    margin-bottom: 8px;
                    color: #333;
                }

                .filter-group input,
                .filter-group select {
                    padding: 10px 12px;
                    border: 1px solid #ddd;
                    border-radius: 6px;
                    font-size: 14px;
                }

                .filter-group input:focus,
                .filter-group select:focus {
                    border-color: #10a37f;
                    outline: none;
                    box-shadow: 0 0 0 3px rgba(16, 163, 127, 0.1);
                }
            </style>
        </div>

        <!-- Data Table -->
        <div class="table-section">
            <div class="section-header">
                <h3 style="margin: 0; font-size: 1.3rem;">
                    <i class="bi bi-table"></i> Daftar Pembayaran ({{ $pembayarans->total() }})
                </h3>
            </div>

            @if ($pembayarans->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Penyewa</th>
                                <th>Kos</th>
                                <th>Jumlah</th>
                                <th>Status</th>
                                <th>Metode</th>
                                <th>Tanggal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pembayarans as $pembayaran)
                                <tr>
                                    <td>
                                        <div class="user-info-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($pembayaran->booking->penyewa->name) }}&background=10a37f&color=fff"
                                                alt="{{ $pembayaran->booking->penyewa->name }}" class="avatar-sm">
                                            <div>
                                                <div style="font-weight: 600;">{{ $pembayaran->booking->penyewa->name }}</div>
                                                <div style="font-size: 12px; color: #999;">{{ $pembayaran->booking->penyewa->email }}</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600;">{{ $pembayaran->booking->kos->nama_kos }}</div>
                                        <div style="font-size: 12px; color: #999;">Booking ID: {{ $pembayaran->booking->id }}</div>
                                    </td>
                                    <td>
                                        <div style="font-weight: 600; font-size: 15px;">
                                            Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                                        </div>
                                    </td>
                                    <td>
                                        <span class="status-badge" style="
                                            padding: 6px 12px;
                                            border-radius: 20px;
                                            font-size: 12px;
                                            font-weight: 600;
                                            @switch($pembayaran->status)
                                                @case('pending')
                                                    background-color: #fff3cd;
                                                    color: #856404;
                                                    @break
                                                @case('lunas')
                                                    background-color: #d4edda;
                                                    color: #155724;
                                                    @break
                                                @case('terlambat')
                                                    background-color: #f8d7da;
                                                    color: #721c24;
                                                    @break
                                            @endswitch
                                        ">
                                            @switch($pembayaran->status)
                                                @case('pending')
                                                    <i class="bi bi-clock"></i> Pending
                                                    @break
                                                @case('lunas')
                                                    <i class="bi bi-check-circle"></i> Lunas
                                                    @break
                                                @case('terlambat')
                                                    <i class="bi bi-exclamation-circle"></i> Terlambat
                                                    @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <span class="badge" style="
                                            @switch($pembayaran->metode_pembayaran)
                                                @case('transfer')
                                                    background-color: #e7f3ff;
                                                    color: #0066cc;
                                                    @break
                                                @case('kartu_kredit')
                                                    background-color: #fff5e7;
                                                    color: #cc6600;
                                                    @break
                                                @case('e_wallet')
                                                    background-color: #e7f5e7;
                                                    color: #006600;
                                                    @break
                                            @endswitch
                                        ">
                                            @switch($pembayaran->metode_pembayaran)
                                                @case('transfer')
                                                    <i class="bi bi-bank"></i> Transfer
                                                    @break
                                                @case('kartu_kredit')
                                                    <i class="bi bi-credit-card"></i> Kartu
                                                    @break
                                                @case('e_wallet')
                                                    <i class="bi bi-wallet2"></i> E-Wallet
                                                    @break
                                            @endswitch
                                        </span>
                                    </td>
                                    <td>
                                        <div style="font-size: 13px;">
                                            {{ $pembayaran->created_at->format('d M Y') }}
                                        </div>
                                        <div style="font-size: 11px; color: #999;">
                                            {{ $pembayaran->created_at->format('H:i') }}
                                        </div>
                                    </td>
                                    <td>
                                        <a href="{{ route('admin.pembayaran.show', $pembayaran) }}" 
                                            class="btn btn-sm btn-primary" title="Lihat Detail">
                                            <i class="bi bi-eye"></i> Lihat
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($pembayarans->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        {{ $pembayarans->links() }}
                    </nav>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Tidak ada data pembayaran yang sesuai dengan filter</p>
                </div>
            @endif
        </div>

        <!-- Back Button -->
        <div class="mt-5">
            <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali ke Dashboard
            </a>
        </div>
    </div>

    <style>
        .user-info-cell {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .avatar-sm {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            flex-shrink: 0;
        }

        .table-section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: #999;
        }

        .empty-state i {
            font-size: 3rem;
            margin-bottom: 15px;
            opacity: 0.5;
        }

        .btn-primary, .btn-secondary {
            padding: 8px 16px;
            border-radius: 6px;
            border: none;
            cursor: pointer;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary {
            background-color: #10a37f;
            color: white;
        }

        .btn-primary:hover {
            background-color: #0d8a6a;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(16, 163, 127, 0.3);
        }

        .btn-secondary {
            background-color: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        @media (max-width: 768px) {
            .table-responsive {
                font-size: 13px;
            }

            .filter-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endsection
