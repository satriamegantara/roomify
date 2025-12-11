@extends('layouts.app')

@section('title', 'Kelola Kos - Admin')

@section('content')
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 fw-bold mb-1">Kelola Kos (Admin)</h1>
            <p class="text-muted mb-0">Verifikasi dan kelola status semua kos yang terdaftar</p>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm border-0 mb-4">
        <div class="card-body">
            <form class="row g-3 align-items-end" method="GET" action="{{ route('admin.kos.index') }}">
                <div class="col-md-4">
                    <label class="form-label">Status</label>
                    <select name="status" class="form-select">
                        <option value="">Semua</option>
                        <option value="aktif" {{ $status === 'aktif' ? 'selected' : '' }}>Aktif</option>
                        <option value="tidak_aktif" {{ $status === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                        <option value="penuh" {{ $status === 'penuh' ? 'selected' : '' }}>Penuh</option>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Verifikasi</label>
                    <select name="verification" class="form-select">
                        <option value="">Semua</option>
                        <option value="verified" {{ $verification === 'verified' ? 'selected' : '' }}>Terverifikasi</option>
                        <option value="unverified" {{ $verification === 'unverified' ? 'selected' : '' }}>Belum Verifikasi
                        </option>
                    </select>
                </div>
                <div class="col-md-4 d-flex align-items-end gap-2">
                    <button class="btn btn-primary" type="submit"><i class="bi bi-funnel me-2"></i>Filter</button>
                    <a class="btn btn-outline-secondary" href="{{ route('admin.kos.index') }}">Reset</a>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>#</th>
                            <th>Alamat</th>
                            <th>Pemilik</th>
                            <th>Harga</th>
                            <th>Jenis</th>
                            <th>Status</th>
                            <th>Verifikasi</th>
                            <th class="text-end">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($kosList as $kos)
                            <tr>
                                <td>{{ $kos->id }}</td>
                                <td class="fw-semibold">{{ $kos->alamat ?? '-' }}</td>
                                <td>
                                    <div class="fw-semibold">{{ $kos->pemilik->name ?? '-' }}</div>
                                    <div class="text-muted small">{{ $kos->pemilik->email ?? '' }}</div>
                                </td>
                                <td>Rp {{ number_format($kos->harga_bulanan, 0, ',', '.') }}</td>
                                <td class="text-capitalize">{{ $kos->jenis_kos }}</td>
                                <td>
                                    @php
                                        $statusClass = [
                                            'aktif' => 'success',
                                            'tidak_aktif' => 'secondary',
                                            'penuh' => 'warning',
                                        ][$kos->status] ?? 'secondary';
                                    @endphp
                                    <span class="badge bg-{{ $statusClass }} text-uppercase">{{ $kos->status }}</span>
                                </td>
                                <td>
                                    @if($kos->verified_at)
                                        <span class="badge bg-primary">Terverifikasi</span>
                                        <div class="text-muted small">{{ $kos->verified_at->format('d M Y') }}</div>
                                    @else
                                        <span class="badge bg-light text-muted border">Belum</span>
                                    @endif
                                </td>
                                <td class="text-end">
                                    <div class="d-flex justify-content-end gap-2 flex-wrap">
                                        <form method="POST" action="{{ route('admin.kos.verify', $kos) }}">
                                            @csrf
                                            <button
                                                class="btn btn-sm {{ $kos->verified_at ? 'btn-outline-danger' : 'btn-outline-success' }}"
                                                type="submit">
                                                <i
                                                    class="bi {{ $kos->verified_at ? 'bi-x-circle' : 'bi-patch-check' }} me-1"></i>
                                                {{ $kos->verified_at ? 'Batalkan' : 'Verifikasi' }}
                                            </button>
                                        </form>
                                        <form method="POST" action="{{ route('admin.kos.status', $kos) }}" class="d-flex gap-2">
                                            @csrf
                                            <select name="status" class="form-select form-select-sm">
                                                <option value="aktif" {{ $kos->status === 'aktif' ? 'selected' : '' }}>Aktif
                                                </option>
                                                <option value="tidak_aktif" {{ $kos->status === 'tidak_aktif' ? 'selected' : '' }}>Tidak Aktif</option>
                                                <option value="penuh" {{ $kos->status === 'penuh' ? 'selected' : '' }}>Penuh
                                                </option>
                                            </select>
                                            <button class="btn btn-sm btn-outline-primary" type="submit">Simpan</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center py-4 text-muted">Belum ada data kos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="p-3">
                {{ $kosList->links() }}
            </div>
        </div>
    </div>
@endsection