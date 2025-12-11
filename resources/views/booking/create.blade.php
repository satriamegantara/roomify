@extends('layouts.app')

@section('title', 'Buat Booking')

@section('content')
<div class="row">
    <div class="col-lg-8 offset-lg-2">
        <a href="{{ route('booking.index') }}" class="btn btn-outline-primary mb-3">
            <i class="bi bi-arrow-left me-2"></i>Kembali
        </a>

        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <h5 class="mb-0"><i class="bi bi-calendar-check me-2"></i>Buat Booking untuk {{ $kos->alamat }}</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('booking.store', $kos) }}" method="POST">
                    @csrf

                    <div class="mb-4 p-3 bg-light-primary rounded">
                        <h6 class="mb-3">Informasi Kos</h6>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Alamat</p>
                                <p class="fw-semibold">{{ $kos->alamat }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Jenis Kos</p>
                                <p class="fw-semibold">
                                    @switch($kos->jenis_kos)
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
                                <p class="fw-semibold text-primary">Rp{{ number_format($kos->harga_bulanan, 0, ',', '.') }}</p>
                            </div>
                            <div class="col-md-6">
                                <p class="text-muted small mb-1">Pemilik</p>
                                <p class="fw-semibold">{{ $kos->pemilik->name }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="tanggal_kunjungan" class="form-label">Tanggal Kunjungan <span class="text-danger">*</span></label>
                        <input type="date" 
                               class="form-control @error('tanggal_kunjungan') is-invalid @enderror" 
                               id="tanggal_kunjungan" 
                               name="tanggal_kunjungan" 
                               value="{{ old('tanggal_kunjungan') }}"
                               min="{{ now()->addDay()->format('Y-m-d') }}"
                               required>
                        @error('tanggal_kunjungan')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted d-block mt-2">
                            <i class="bi bi-info-circle me-1"></i>Pilih tanggal untuk berkunjung ke kos
                        </small>
                    </div>

                    <div class="card mb-3 bg-light-primary">
                        <div class="card-body">
                            <p class="mb-0">
                                <i class="bi bi-lightbulb me-2"></i>
                                <strong>Tips:</strong> Pilih tanggal yang tepat untuk bertemu dengan pemilik dan melihat kondisi kos secara langsung.
                            </p>
                        </div>
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="bi bi-check-circle me-2"></i>Konfirmasi Booking
                        </button>
                        <a href="{{ route('kos.show', $kos) }}" class="btn btn-outline-secondary">
                            Kembali ke Detail Kos
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
