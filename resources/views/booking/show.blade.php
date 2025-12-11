@extends('layouts.app')

@section('title', 'Detail Booking')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <a href="{{ route('booking.index') }}" class="btn btn-outline-primary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>

        <div class="row g-4">
            <!-- Detail Booking -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-file-text me-2"></i>Detail Booking</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Status</p>
                                <p>
                                    <span class="badge status-{{ $booking->status }} fs-6">
                                        {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                    </span>
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Tanggal Kunjungan</p>
                                <p class="fw-semibold">
                                    @if ($booking->tanggal_kunjungan)
                                        {{ $booking->tanggal_kunjungan->format('d F Y') }}
                                    @else
                                        <span class="text-muted">-</span>
                                    @endif
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Dibuat Pada</p>
                                <p class="fw-semibold">{{ $booking->created_at->format('d F Y H:i') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Diperbarui Pada</p>
                                <p class="fw-semibold">{{ $booking->updated_at->format('d F Y H:i') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Kos Info -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-house me-2"></i>Informasi Kos</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-4">
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Alamat</p>
                                <p class="fw-semibold">{{ $booking->kos->alamat }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Jenis Kos</p>
                                <p class="fw-semibold">
                                    @switch($booking->kos->jenis_kos)
                                        @case('putra')
                                            <i class="bi bi-person me-1"></i>Kos Putra
                                            @break
                                        @case('putri')
                                            <i class="bi bi-person-fill me-1"></i>Kos Putri
                                            @break
                                        @default
                                            <i class="bi bi-people me-1"></i>Kos Campur
                                    @endswitch
                                </p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Harga per Bulan</p>
                                <p class="fw-semibold text-primary">Rp{{ number_format($booking->kos->harga_bulanan, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Rating</p>
                                <div>
                                    @php
                                        $rating = $booking->kos->getAverageRating();
                                        $ratingCount = $booking->kos->ratingUlasans->count();
                                    @endphp
                                    @for ($i = 1; $i <= 5; $i++)
                                        @if ($i <= $rating)
                                            <i class="bi bi-star-fill text-warning"></i>
                                        @else
                                            <i class="bi bi-star text-warning"></i>
                                        @endif
                                    @endfor
                                    <span class="ms-2">{{ $rating }}/5</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Penyewa Info -->
            <div class="col-lg-4">
                <div class="card border-0 shadow-sm mb-4">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Penyewa</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10a37f, #059669); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h5>{{ $booking->penyewa->name }}</h5>
                        <p class="text-muted small">{{ $booking->penyewa->email }}</p>
                    </div>
                </div>

                <!-- Pemilik Info -->
                <div class="card border-0 shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person-check me-2"></i>Pemilik Kos</h5>
                    </div>
                    <div class="card-body text-center">
                        <div class="avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10a37f, #059669); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <i class="bi bi-person-fill"></i>
                        </div>
                        <h5>{{ $booking->kos->pemilik->name }}</h5>
                        <p class="text-muted small">{{ $booking->kos->pemilik->email }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Action Buttons -->
        @if ($booking->status !== 'dibatalkan' && $booking->status !== 'selesai')
            <div class="mt-4">
                <form action="{{ route('booking.cancel', $booking) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <button type="submit" class="btn btn-outline-danger" onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                        <i class="bi bi-x-circle me-2"></i>Batalkan Booking
                    </button>
                </form>
            </div>
        @endif
    </div>
</div>
@endsection
