@extends('layouts.app')

@push('styles')
    @vite('resources/css/admin-dashboard.css')
@endpush

@section('title', 'Manajemen User Admin')

@section('content')
    <div class="admin-dashboard">
        <!-- Header -->
        <div class="dashboard-header">
            <h1 class="header-title">
                <i class="bi bi-people"></i>Manajemen Pengguna
            </h1>
            <p class="header-subtitle">Verifikasi dan kelola pengguna yang baru terdaftar</p>
        </div>

        <!-- Stats -->
        <div class="stats-grid"
            style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-bottom: 30px;">
            <div class="stat-card users">
                <div class="stat-icon">
                    <i class="bi bi-people"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalUsers }}</div>
                    <div class="stat-label">Total Pengguna</div>
                </div>
            </div>

            <div class="stat-card unverified">
                <div class="stat-icon">
                    <i class="bi bi-exclamation-circle"></i>
                </div>
                <div class="stat-content">
                    <div class="stat-value">{{ $totalPending }}</div>
                    <div class="stat-label">Menunggu Verifikasi</div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="bi bi-check-circle"></i> {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Pending Verification Tab -->
        <div class="table-section">
            <div class="section-header">
                <h2>
                    <i class="bi bi-clock-history"></i>
                    Menunggu Verifikasi ({{ count($pendingUsers) }})
                </h2>
            </div>

            @if ($pendingUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Terdaftar</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pendingUsers as $user)
                                <tr>
                                    <td>
                                        <div class="user-info-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10a37f&color=fff"
                                                alt="{{ $user->name }}" class="avatar-sm">
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-info">
                                            @if ($user->role === 'pemilik')
                                                <i class="bi bi-building"></i> Pemilik
                                            @elseif ($user->role === 'penyewa')
                                                <i class="bi bi-person-check"></i> Penyewa
                                            @else
                                                <i class="bi bi-person"></i> {{ ucfirst($user->role) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>{{ $user->created_at->diffForHumans() }}</td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('admin.users.verify', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-success" title="Verifikasi User">
                                                    <i class="bi bi-check-circle"></i> Verifikasi
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.reject', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Tolak User"
                                                    onclick="return confirm('Tolak user ini?')">
                                                    <i class="bi bi-x-circle"></i> Tolak
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus User"
                                                    onclick="return confirm('Hapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($pendingUsers->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        {{ $pendingUsers->links() }}
                    </nav>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-check-circle"></i>
                    <p>Tidak ada user yang menunggu verifikasi</p>
                </div>
            @endif
        </div>

        <!-- Verified Users Tab -->
        <div class="table-section" style="margin-top: 40px;">
            <div class="section-header">
                <h2>
                    <i class="bi bi-check-circle"></i>
                    User Terverifikasi ({{ count($verifiedUsers) }})
                </h2>
            </div>

            @if ($verifiedUsers->count() > 0)
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Email</th>
                                <th>Role</th>
                                <th>Diverifikasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($verifiedUsers as $user)
                                <tr>
                                    <td>
                                        <div class="user-info-cell">
                                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10a37f&color=fff"
                                                alt="{{ $user->name }}" class="avatar-sm">
                                            <span>{{ $user->name }}</span>
                                        </div>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        <span class="badge bg-success">
                                            @if ($user->role === 'pemilik')
                                                <i class="bi bi-building"></i> Pemilik
                                            @elseif ($user->role === 'penyewa')
                                                <i class="bi bi-person-check"></i> Penyewa
                                            @else
                                                <i class="bi bi-person"></i> {{ ucfirst($user->role) }}
                                            @endif
                                        </span>
                                    </td>
                                    <td>
                                        @if ($user->verified_at)
                                            {{ $user->verified_at->format('d M Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <form action="{{ route('admin.users.reject', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                <button type="submit" class="btn btn-sm btn-warning" title="Cabut Verifikasi">
                                                    <i class="bi bi-x-circle"></i> Cabut Verifikasi
                                                </button>
                                            </form>

                                            <form action="{{ route('admin.users.destroy', $user) }}" method="POST"
                                                style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus User"
                                                    onclick="return confirm('Hapus user ini? Tindakan ini tidak dapat dibatalkan.')">
                                                    <i class="bi bi-trash"></i> Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                @if ($verifiedUsers->hasPages())
                    <nav aria-label="Page navigation" class="mt-4">
                        {{ $verifiedUsers->links() }}
                    </nav>
                @endif
            @else
                <div class="empty-state">
                    <i class="bi bi-inbox"></i>
                    <p>Tidak ada user terverifikasi</p>
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
            gap: 10px;
        }

        .avatar-sm {
            width: 32px;
            height: 32px;
            border-radius: 50%;
        }

        .action-buttons {
            display: flex;
            gap: 5px;
        }

        .action-buttons form {
            margin: 0;
        }

        .section-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        .section-header h2 {
            margin: 0;
            font-size: 1.5rem;
            color: #333;
        }

        .table-section {
            background: white;
            border-radius: 8px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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

        .alert {
            margin-bottom: 20px;
        }

        @media (max-width: 768px) {
            .action-buttons {
                flex-direction: column;
            }

            .action-buttons .btn {
                width: 100%;
            }

            .section-header {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
@endsection