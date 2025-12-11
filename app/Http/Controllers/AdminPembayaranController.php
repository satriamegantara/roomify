<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPembayaranController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of all payments with filters.
     */
    public function index(Request $request): View
    {
        $query = Pembayaran::with(['booking.penyewa', 'booking.kos']);

        // Filter by status
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Filter by payment method
        if ($request->filled('metode_pembayaran')) {
            $query->where('metode_pembayaran', $request->metode_pembayaran);
        }

        // Filter by date range
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // Filter by penyewa name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('booking.penyewa', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Get stats
        $totalPembayaran = Pembayaran::count();
        $totalAmount = Pembayaran::sum('jumlah');
        $lunasCount = Pembayaran::where('status', 'lunas')->count();
        $lunasAmount = Pembayaran::where('status', 'lunas')->sum('jumlah');
        $pendingAmount = Pembayaran::where('status', 'pending')->sum('jumlah');
        $lateCount = Pembayaran::where('status', 'terlambat')->count();

        // Paginate results
        $pembayarans = $query->latest()->paginate(15);

        return view('admin.pembayaran.index', compact(
            'pembayarans',
            'totalPembayaran',
            'totalAmount',
            'lunasCount',
            'lunasAmount',
            'pendingAmount',
            'lateCount'
        ));
    }

    /**
     * Display payment details.
     */
    public function show(Pembayaran $pembayaran): View
    {
        $pembayaran->load(['booking.penyewa', 'booking.kos']);

        return view('admin.pembayaran.show', compact('pembayaran'));
    }
}
