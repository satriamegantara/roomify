<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Kos;
use App\Models\Pembayaran;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        // Check if user is owner
        $ownedKos = $user->kosAsOwner;
        $totalKos = $ownedKos->count();
        $activeBookings = Booking::whereIn('kos_id', $ownedKos->pluck('id'))
            ->where('status', 'aktif')
            ->count();
        $totalRevenue = Pembayaran::whereIn('kos_id', $ownedKos->pluck('id'))
            ->where('status', 'lunas')
            ->sum('jumlah');

        // Tenant stats
        $myBookings = $user->bookings()->count();
        $myPayments = $user->pembayarans()->sum('jumlah');
        $pendingPayments = $user->pembayarans()
            ->where('status', 'pending')
            ->sum('jumlah');

        return view('dashboard', compact(
            'totalKos',
            'activeBookings',
            'totalRevenue',
            'myBookings',
            'myPayments',
            'pendingPayments'
        ));
    }
}
