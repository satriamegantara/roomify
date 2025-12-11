<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PembayaranController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $query = auth()->user()->pembayarans()
            ->with('kos')
            ->latest();

        if (request('status')) {
            $query->where('status', request('status'));
        }

        $pembayarans = $query->paginate(10);

        return view('pembayaran.index', compact('pembayarans'));
    }

    public function show(Pembayaran $pembayaran): View
    {
        if ($pembayaran->penyewa_id !== auth()->id()) {
            abort(403);
        }

        return view('pembayaran.show', compact('pembayaran'));
    }

    public function uploadBukti(Request $request, Pembayaran $pembayaran)
    {
        if ($pembayaran->penyewa_id !== auth()->id()) {
            abort(403);
        }

        $validated = $request->validate([
            'bukti_transfer' => 'required|image|max:2048',
        ]);

        if ($request->hasFile('bukti_transfer')) {
            $path = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
            $pembayaran->update(['bukti_transfer' => $path]);
        }

        return back()->with('success', 'Bukti transfer berhasil diunggah.');
    }
}
