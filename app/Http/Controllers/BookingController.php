<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kos;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $bookings = auth()->user()->bookings()
            ->with('kos.pemilik')
            ->latest()
            ->paginate(10);

        return view('booking.index', compact('bookings'));
    }

    public function create(Kos $kos): View
    {
        return view('booking.create', compact('kos'));
    }

    public function store(Request $request, Kos $kos): RedirectResponse
    {
        $validated = $request->validate([
            'tanggal_kunjungan' => 'required|date|after:today',
        ], [
            'tanggal_kunjungan.required' => 'Tanggal kunjungan harus diisi',
            'tanggal_kunjungan.date' => 'Format tanggal tidak valid',
            'tanggal_kunjungan.after' => 'Tanggal harus setelah hari ini',
        ]);

        auth()->user()->bookings()->create([
            'kos_id' => $kos->id,
            'tanggal_kunjungan' => $validated['tanggal_kunjungan'],
            'status' => 'pending',
        ]);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dibuat. Silakan tunggu konfirmasi dari pemilik.');
    }

    public function show(Booking $booking): View
    {
        $this->authorize('view', $booking);

        $booking->load('kos.pemilik', 'penyewa');

        return view('booking.show', compact('booking'));
    }

    public function cancel(Booking $booking): RedirectResponse
    {
        $this->authorize('delete', $booking);

        $booking->update(['status' => 'dibatalkan']);

        return redirect()->route('booking.index')
            ->with('success', 'Booking berhasil dibatalkan.');
    }
}
