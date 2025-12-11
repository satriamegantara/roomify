<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

class AdminUserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('admin');
    }

    /**
     * Display a listing of users pending verification.
     */
    public function index(): View
    {
        $pendingUsers = User::where('is_verified', false)
            ->latest()
            ->paginate(15);

        $verifiedUsers = User::where('is_verified', true)
            ->latest()
            ->paginate(15);

        $totalUsers = User::count();
        $totalPending = User::where('is_verified', false)->count();

        return view('admin.users.index', compact(
            'pendingUsers',
            'verifiedUsers',
            'totalUsers',
            'totalPending'
        ));
    }

    /**
     * Verify a user.
     */
    public function verify(User $user): RedirectResponse
    {
        $user->update([
            'is_verified' => true,
            'verified_at' => now(),
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User ' . $user->name . ' berhasil diverifikasi');
    }

    /**
     * Reject/unverify a user.
     */
    public function reject(User $user): RedirectResponse
    {
        $user->update([
            'is_verified' => false,
            'verified_at' => null,
        ]);

        return redirect()->route('admin.users.index')
            ->with('success', 'User ' . $user->name . ' status verifikasinya dicabut');
    }

    /**
     * Delete a user.
     */
    public function destroy(User $user): RedirectResponse
    {
        $userName = $user->name;
        $user->delete();

        return redirect()->route('admin.users.index')
            ->with('success', 'User ' . $userName . ' berhasil dihapus');
    }
}
