<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Booking;

class BookingPolicy
{
    public function view(User $user, Booking $booking): bool
    {
        return $user->id === $booking->penyewa_id || $user->id === $booking->kos->pemilik_id;
    }

    public function delete(User $user, Booking $booking): bool
    {
        return $user->id === $booking->penyewa_id;
    }
}
