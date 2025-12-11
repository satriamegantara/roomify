@extends('layouts.app')

@section('title', 'Booking Saya')

@section('content')
    <div class="row mb-4">
        <div class="col">
            <h1 class="display-5 fw-bold text-primary">
                <i class="bi bi-calendar-check me-2"></i>Booking Saya
            </h1>
        </div>
        <div class="col-auto">
            <a href="{{ route('kos.index') }}" class="btn btn-outline-primary">
                <i class="bi bi-plus-circle me-2"></i>Booking Baru
            </a>
        </div>
    </div>

    @if ($bookings->count() > 0)
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Kos</th>
                        <th>Tanggal Kunjungan</th>
                        <th>Status</th>
                        <th>Dibuat</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($bookings as $booking)
                        <tr>
                            <td>
                                <div>
                                    <h6 class="mb-1">{{ $booking->kos->alamat }}</h6>
                                    <small class="text-muted">Pemilik: {{ $booking->kos->pemilik->name }}</small>
                                </div>
                            </td>
                            <td>
                                @if ($booking->tanggal_kunjungan)
                                    {{ $booking->tanggal_kunjungan->format('d M Y') }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <span class="badge status-{{ $booking->status }}">
                                    {{ ucfirst(str_replace('_', ' ', $booking->status)) }}
                                </span>
                            </td>
                            <td>
                                <small class="text-muted">{{ $booking->created_at->format('d M Y') }}</small>
                            </td>
                            <td>
                                <div class="btn-group btn-group-sm">
                                    <a href="{{ route('booking.show', $booking) }}" class="btn btn-outline-primary"
                                        title="Lihat Detail">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    @if ($booking->status !== 'dibatalkan' && $booking->status !== 'selesai')
                                        <form action="{{ route('booking.cancel', $booking) }}" method="POST" style="display: inline;">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" class="btn btn-outline-danger" title="Batalkan"
                                                onclick="return confirm('Apakah Anda yakin ingin membatalkan booking ini?')">
                                                <i class="bi bi-x-circle"></i>
                                            </button>
                                        </form>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $bookings->links('pagination::bootstrap-5') }}
        </div>
    @else
        <div class="alert alert-info" role="alert">
            <i class="bi bi-info-circle me-2"></i>
            Anda belum memiliki booking. <a href="{{ route('kos.index') }}">Mulai cari kos sekarang</a>
        </div>
    @endif
@endsection