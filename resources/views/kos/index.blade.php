@extends('layouts.app')

@section('title', 'Listing Kos')

@section('content')
<div class="hero-section-modern mb-5">
    <div class="container-lg">
        <div class="text-center mb-4">
            <h1 class="hero-title mb-3">Temukan Kos Impianmu</h1>
            <p class="hero-subtitle">Platform terpercaya untuk mencari kos berkualitas di seluruh kota</p>
        </div>

        <form action="{{ route('kos.search') }}" method="GET" class="search-form-modern mx-auto">
            <div class="search-container">
                <div class="search-input-group">
                    <i class="bi bi-geo-alt search-icon"></i>
                    <input type="text" name="q" class="search-input" placeholder="Cari berdasarkan alamat..." value="{{ request('q') }}">
                </div>
                <div class="search-select-group">
                    <i class="bi bi-funnel search-icon"></i>
                    <select name="jenis_kos" class="search-select">
                        <option value="">Semua Jenis</option>
                        <option value="putra" @selected(request('jenis_kos') == 'putra')>Kos Putra</option>
                        <option value="putri" @selected(request('jenis_kos') == 'putri')>Kos Putri</option>
                        <option value="campur" @selected(request('jenis_kos') == 'campur')>Kos Campur</option>
                    </select>
                </div>
                <button type="submit" class="search-btn">
                    <i class="bi bi-search"></i>
                    <span class="d-none d-md-inline ms-2">Cari</span>
                </button>
            </div>
        </form>
    </div>
</div>

<div class="container-lg">
    @if ($kos->count() > 0)
        <div class="listing-header mb-4">
            <h2 class="listing-title">{{ $kos->total() }} Kos Tersedia</h2>
            <p class="listing-subtitle">Pilih kos yang sesuai dengan kebutuhan Anda</p>
        </div>
        <div class="row g-4 mb-5">
            @foreach ($kos as $item)
                <div class="col-md-6 col-lg-4">
                    <div class="kos-card h-100">
                        <div class="kos-card-image">
                            @if ($item->foto_utama)
                                <img src="{{ asset('storage/' . $item->foto_utama) }}" alt="Foto Kos">
                            @else
                                <img src="https://via.placeholder.com/400x300?text=Kos" alt="Foto Kos">
                            @endif
                            <div class="kos-card-overlay">
                                <span class="badge kos-status-{{ $item->status }}">
                                    {{ ucfirst($item->status) }}
                                </span>
                                <span class="badge kos-type">
                                    @switch($item->jenis_kos)
                                        @case('putra')
                                            <i class="bi bi-person me-1"></i>Putra
                                            @break
                                        @case('putri')
                                            <i class="bi bi-person-fill me-1"></i>Putri
                                            @break
                                        @default
                                            <i class="bi bi-people me-1"></i>Campur
                                    @endswitch
                                </span>
                            </div>
                        </div>
                        <div class="kos-card-body">
                            <h5 class="kos-title">{{ $item->alamat }}</h5>
                            
                            <div class="kos-rating mb-3">
                                @php
                                    $rating = $item->getAverageRating();
                                    $ratingCount = $item->ratingUlasans->count();
                                @endphp
                                <div class="rating-stars">
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="bi bi-star-fill"></i>
                                        @else
                                            <i class="bi bi-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="rating-text">{{ $rating }} ({{ $ratingCount }} ulasan)</span>
                            </div>

                            <div class="kos-price-section">
                                <div class="price-label">Harga per Bulan</div>
                                <div class="price-amount">Rp{{ number_format($item->harga_bulanan, 0, ',', '.') }}</div>
                            </div>
                        </div>
                        <div class="kos-card-footer">
                            <a href="{{ route('kos.show', $item) }}" class="btn-detail">
                                Lihat Detail
                                <i class="bi bi-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mb-5">
            {{ $kos->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="text-center py-5">
            <i class="bi bi-search" style="font-size: 4rem; color: #d1d5db;"></i>
            <h4 class="mt-3 text-muted">Kos Tidak Ditemukan</h4>
            <p class="text-muted">Coba ubah pencarian Anda</p>
            <a href="{{ route('kos.index') }}" class="btn btn-primary mt-3">Lihat Semua Kos</a>
        </div>
    @endif
</div>
@endsection
