<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Kos;
use App\Models\Booking;
use App\Models\Pembayaran;
use App\Models\RatingUlasan;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        // User Stats
        $totalUsers = User::count();
        $pemiliks = User::where('role', 'pemilik')->count();
        $penyewas = User::where('role', 'penyewa')->count();
        $admins = User::where('role', 'admin')->count();

        // Kos Stats
        $totalKos = Kos::count();
        $verifiedKos = Kos::whereNotNull('verified_at')->count();
        $unverifiedKos = Kos::whereNull('verified_at')->count();
        $aktifKos = Kos::where('status', 'aktif')->count();

        // Booking Stats
        $totalBookings = Booking::count();
        $pendingBookings = Booking::where('status', 'pending')->count();
        $aktifBookings = Booking::where('status', 'aktif')->count();
        $selesaiBookings = Booking::where('status', 'selesai')->count();
        $dibatalkanBookings = Booking::where('status', 'dibatalkan')->count();

        // Payment Stats
        $totalPembayaran = Pembayaran::count();
        $lunasCount = Pembayaran::where('status', 'lunas')->count();
        $totalLunasAmount = Pembayaran::where('status', 'lunas')->sum('jumlah');
        $pendingPayments = Pembayaran::where('status', 'pending')->count();
        $latePayments = Pembayaran::where('status', 'terlambat')->count();

        // Review Stats
        $totalReviews = RatingUlasan::count();
        $avgRating = RatingUlasan::avg('rating');

        // Recent Data
        $recentKos = Kos::with('pemilik')->latest()->take(5)->get();
        $recentBookings = Booking::with(['penyewa', 'kos'])->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalUsers',
            'pemiliks',
            'penyewas',
            'admins',
            'totalKos',
            'verifiedKos',
            'unverifiedKos',
            'aktifKos',
            'totalBookings',
            'pendingBookings',
            'aktifBookings',
            'selesaiBookings',
            'dibatalkanBookings',
            'totalPembayaran',
            'lunasCount',
            'totalLunasAmount',
            'pendingPayments',
            'latePayments',
            'totalReviews',
            'avgRating',
            'recentKos',
            'recentBookings'
        ));
    }
}
