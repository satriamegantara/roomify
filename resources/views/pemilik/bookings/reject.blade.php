<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tolak Booking - Roomify</title>
    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-booking.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>

<body>
    <main class="booking-main" style="margin-left:0; padding:2rem;">
        <div class="booking-header" style="margin-bottom:1.5rem;">
            <div class="booking-header-top">
                <div>
                    <h1 class="booking-title"><i class="bi bi-x-circle me-2"></i>Tolak Booking</h1>
                    <p class="booking-subtitle">Konfirmasi penolakan untuk booking ini.</p>
                </div>
                <div class="d-flex" style="gap:0.75rem; flex-wrap:wrap;">
                    <a href="{{ route('pemilik.bookings.show', $booking) }}" class="btn btn-outline-secondary">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>
        </div>

        <div class="booking-table-container" style="padding:1.5rem;">
            <h4 style="font-weight:700; color:var(--dark); margin-bottom:1rem;">Detail Singkat</h4>
            <p style="margin:0 0 0.5rem 0; color:var(--text-muted);"><strong>Penyewa:</strong>
                {{ $booking->penyewa->name }}</p>
            <p style="margin:0 0 0.5rem 0; color:var(--text-muted);"><strong>Email:</strong>
                {{ $booking->penyewa->email }}</p>
            <p style="margin:0 0 0.5rem 0; color:var(--text-muted);"><strong>Kos:</strong> {{ $booking->kos->alamat }}
            </p>
            <p style="margin:0; color:var(--text-muted);"><strong>Status Saat Ini:</strong>
                {{ ucfirst($booking->status) }}</p>

            <div style="margin-top:1.5rem; display:flex; gap:0.75rem; flex-wrap:wrap;">
                <form action="{{ route('pemilik.bookings.reject', $booking) }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-danger" onclick="return confirm('Tolak booking ini?')">
                        <i class="bi bi-x-lg me-2"></i>Tolak
                    </button>
                </form>
                <a href="{{ route('pemilik.bookings.index') }}" class="btn btn-outline-secondary">Batal</a>
            </div>
        </div>
    </main>
</body>

</html>