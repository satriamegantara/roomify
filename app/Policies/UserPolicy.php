<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    /**
     * Determine if the user can view a list of all users.
     */
    public function viewAny(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can verify another user.
     */
    public function verify(User $user): bool
    {
        return $user->role === 'admin';
    }

    /**
     * Determine if the user can delete another user.
     */
    public function delete(User $user): bool
    {
        return $user->role === 'admin';
    }
}
