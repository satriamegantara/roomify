<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\Booking;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PemilikDashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Get all kos owned by this user
        $totalKos = Kos::where('pemilik_id', $user->id)->count();

        // Get bookings for all owned kos
        $bookings = Booking::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->with(['kos', 'penyewa'])->latest()->get();

        // Statistics
        $totalBookings = $bookings->count();
        $pendingBookings = $bookings->where('status', 'pending')->count();
        $activeBookings = $bookings->where('status', 'aktif')->count();

        // Get pembayaran for owned kos
        $pembayarans = Pembayaran::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->with(['kos', 'penyewa'])->latest()->take(10)->get();

        // Calculate total revenue
        $totalRevenue = Pembayaran::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->where('status', 'lunas')->sum('jumlah');

        // Pending payments
        $pendingPayments = Pembayaran::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })->where('status', 'pending')->count();

        // Recent bookings
        $recentBookings = $bookings->take(5);

        // Monthly revenue chart data
        $monthlyRevenue = Pembayaran::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })
            ->where('status', 'lunas')
            ->whereYear('created_at', date('Y'))
            ->select(
                DB::raw("CAST(strftime('%m', created_at) as INTEGER) as month"),
                DB::raw('SUM(jumlah) as total')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('pemilik.dashboard', compact(
            'totalKos',
            'totalBookings',
            'pendingBookings',
            'activeBookings',
            'totalRevenue',
            'pendingPayments',
            'recentBookings',
            'pembayarans',
            'monthlyRevenue'
        ));
    }

    public function kos()
    {
        $user = Auth::user();
        $kos = Kos::where('pemilik_id', $user->id)
            ->with(['ratingUlasans', 'bookings'])
            ->latest()
            ->get();

        return view('pemilik.kos', compact('kos'));
    }

    public function bookings()
    {
        $user = Auth::user();
        $bookings = Booking::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })
            ->with(['kos', 'penyewa'])
            ->latest()
            ->paginate(15);

        return view('pemilik.bookings.index', compact('bookings'));
    }

    public function pembayaran()
    {
        $user = Auth::user();
        $pembayarans = Pembayaran::whereHas('kos', function ($query) use ($user) {
            $query->where('pemilik_id', $user->id);
        })
            ->with(['kos', 'penyewa'])
            ->latest()
            ->paginate(15);

        return view('pemilik.pembayaran.index', compact('pembayarans'));
    }

    public function create()
    {
        return view('pemilik.tambah-kos');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'alamat' => 'required|string|max:255',
            'jenis_kos' => 'required|in:putra,putri,campur',
            'harga_bulanan' => 'required|numeric|min:0',
            'foto_utama' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_lainnya' => 'nullable|array',
            'foto_lainnya.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'deskripsi' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();

        // Upload foto utama
        $fotoUtamaPath = $request->file('foto_utama')->store('kos/foto-utama', 'public');

        // Upload foto lainnya
        $fotoLainnyaPaths = [];
        if ($request->hasFile('foto_lainnya')) {
            foreach ($request->file('foto_lainnya') as $foto) {
                $fotoLainnyaPaths[] = $foto->store('kos/foto-lainnya', 'public');
            }
        }

        // Create kos
        $kos = Kos::create([
            'pemilik_id' => $user->id,
            'alamat' => $validated['alamat'],
            'jenis_kos' => $validated['jenis_kos'],
            'harga_bulanan' => $validated['harga_bulanan'],
            'foto_utama' => $fotoUtamaPath,
            'foto_lainnya' => $fotoLainnyaPaths,
            'status' => 'pending',
            'rating_rata_rata' => 0,
        ]);

        return redirect()
            ->route('pemilik.kos.index')
            ->with('success', 'Kos berhasil ditambahkan! Menunggu verifikasi admin.');
    }

    public function edit(Kos $kos)
    {
        // Authorize user
        if (Auth::user()->id !== $kos->pemilik_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        return view('pemilik.edit-kos', compact('kos'));
    }

    public function update(Request $request, Kos $kos)
    {
        // Authorize user
        if (Auth::user()->id !== $kos->pemilik_id && Auth::user()->role !== 'admin') {
            abort(403);
        }

        $validated = $request->validate([
            'alamat' => 'required|string|max:255',
            'jenis_kos' => 'required|in:putra,putri,campur',
            'harga_bulanan' => 'required|numeric|min:0',
            'foto_utama' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'foto_lainnya' => 'nullable|array',
            'foto_lainnya.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'deskripsi' => 'nullable|string|max:1000',
            'status' => 'nullable|in:aktif,tidak_aktif,penuh',
        ]);

        // Update basic info
        $kos->update([
            'alamat' => $validated['alamat'],
            'jenis_kos' => $validated['jenis_kos'],
            'harga_bulanan' => $validated['harga_bulanan'],
            'deskripsi' => $validated['deskripsi'] ?? $kos->deskripsi,
        ]);

        // Update status jika user adalah admin
        if (Auth::user()->role === 'admin' && isset($validated['status'])) {
            $kos->update(['status' => $validated['status']]);
        }

        // Handle foto utama baru
        if ($request->hasFile('foto_utama')) {
            // Delete old foto
            if ($kos->foto_utama) {
                Storage::disk('public')->delete($kos->foto_utama);
            }
            $fotoUtamaPath = $request->file('foto_utama')->store('kos/foto-utama', 'public');
            $kos->update(['foto_utama' => $fotoUtamaPath]);
        }

        // Handle remove foto utama
        if ($request->has('remove_foto_utama')) {
            if ($kos->foto_utama) {
                Storage::disk('public')->delete($kos->foto_utama);
                $kos->update(['foto_utama' => null]);
            }
        }

        // Handle foto lainnya baru
        if ($request->hasFile('foto_lainnya')) {
            $fotoLainnyaPaths = $kos->foto_lainnya ?? [];
            foreach ($request->file('foto_lainnya') as $foto) {
                $fotoLainnyaPaths[] = $foto->store('kos/foto-lainnya', 'public');
            }
            $kos->update(['foto_lainnya' => $fotoLainnyaPaths]);
        }

        // Handle remove foto lainnya
        if ($request->has('remove_foto_lainnya')) {
            $fotoLainnyaPaths = $kos->foto_lainnya ?? [];
            foreach ($request->input('remove_foto_lainnya') as $index) {
                if (isset($fotoLainnyaPaths[$index])) {
                    Storage::disk('public')->delete($fotoLainnyaPaths[$index]);
                    unset($fotoLainnyaPaths[$index]);
                }
            }
            $kos->update(['foto_lainnya' => array_values($fotoLainnyaPaths)]);
        }

        return redirect()
            ->route('pemilik.kos.index')
            ->with('success', 'Kos berhasil diperbarui!');
    }
}
