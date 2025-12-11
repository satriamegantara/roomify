<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminKosController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->get('status');
        $verification = $request->get('verification');

        $kosList = Kos::with('pemilik')
            ->when($status, fn($q) => $q->where('status', $status))
            ->when($verification === 'verified', fn($q) => $q->whereNotNull('verified_at'))
            ->when($verification === 'unverified', fn($q) => $q->whereNull('verified_at'))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('admin.kos.index', compact('kosList', 'status', 'verification'));
    }

    public function verify(Kos $kos): RedirectResponse
    {
        $kos->verified_at = $kos->verified_at ? null : now();
        $kos->save();

        return back()->with('success', $kos->verified_at ? 'Kos berhasil diverifikasi.' : 'Verifikasi kos dibatalkan.');
    }

    public function updateStatus(Request $request, Kos $kos): RedirectResponse
    {
        $data = $request->validate([
            'status' => 'required|in:aktif,tidak_aktif,penuh',
        ]);

        $kos->update(['status' => $data['status']]);

        return back()->with('success', 'Status kos berhasil diperbarui.');
    }
}
