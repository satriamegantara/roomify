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

        // Penyewa dashboard data
        $myBookings = $user->bookings()->with(['kos'])->whereNot('status', 'dibatalkan')->latest()->get();
        $activeBookings = $myBookings->where('status', 'aktif')->count();
        $pendingBookings = $myBookings->where('status', 'pending')->count();
        $completedBookings = $myBookings->where('status', 'selesai')->count();

        $myPayments = $user->pembayarans()->with(['kos'])->latest()->get();
        $totalPaid = $myPayments->where('status', 'lunas')->sum('jumlah');
        $pendingPayments = $myPayments->where('status', 'pending')->count();
        $pendingAmount = $myPayments->where('status', 'pending')->sum('jumlah');
        $latePayments = $myPayments->where('status', 'terlambat')->count();

        return view('penyewa.dashboard', compact(
            'user',
            'myBookings',
            'activeBookings',
            'pendingBookings',
            'completedBookings',
            'myPayments',
            'totalPaid',
            'pendingPayments',
            'pendingAmount',
            'latePayments'
        ));
    }
}
