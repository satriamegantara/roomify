<?php

namespace App\Http\Controllers;

use App\Models\RatingUlasan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RatingController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'kos_id' => 'required|exists:kos,id',
            'rating' => 'required|integer|between:1,5',
            'ulasan' => 'nullable|string|max:500',
        ]);

        $existingRating = RatingUlasan::where('penyewa_id', auth()->id())
            ->where('kos_id', $validated['kos_id'])
            ->first();

        if ($existingRating) {
            $existingRating->update([
                'rating' => $validated['rating'],
                'ulasan' => $validated['ulasan'],
            ]);
        } else {
            RatingUlasan::create([
                'penyewa_id' => auth()->id(),
                'kos_id' => $validated['kos_id'],
                'rating' => $validated['rating'],
                'ulasan' => $validated['ulasan'],
            ]);
        }

        return back()->with('success', 'Rating berhasil disimpan.');
    }
}
