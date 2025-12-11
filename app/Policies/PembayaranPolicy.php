<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Pembayaran;

class PembayaranPolicy
{
    public function view(User $user, Pembayaran $pembayaran): bool
    {
        return $user->id === $pembayaran->penyewa_id || $user->id === $pembayaran->kos->pemilik_id;
    }

    public function update(User $user, Pembayaran $pembayaran): bool
    {
        return $user->id === $pembayaran->penyewa_id;
    }
}
