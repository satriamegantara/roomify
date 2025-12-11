<?php

namespace App\Http\Controllers;

use App\Models\Kos;
use App\Models\RatingUlasan;
use Illuminate\Http\Request;
use Illuminate\View\View;

class KosController extends Controller
{
    public function index(): View
    {
        $kos = Kos::with('pemilik', 'ratingUlasans')
            ->where('verified_at', '!=', null)
            ->paginate(12);

        return view('kos.index', compact('kos'));
    }

    public function show(Kos $kos): View
    {
        $kos->load(['pemilik', 'ratingUlasans.penyewa']);

        return view('kos.show', compact('kos'));
    }

    public function search(Request $request): View
    {
        $query = $request->get('q', '');
        $jenisKos = $request->get('jenis_kos', '');

        $kos = Kos::query()
            ->where('verified_at', '!=', null);

        if ($query) {
            $kos->where('alamat', 'like', "%$query%");
        }

        if ($jenisKos) {
            $kos->where('jenis_kos', $jenisKos);
        }

        $kos = $kos->paginate(12);

        return view('kos.index', compact('kos', 'query', 'jenisKos'));
    }
}
