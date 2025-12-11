<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Chat;

class ChatPolicy
{
    public function view(User $user, Chat $chat): bool
    {
        return $user->id === $chat->sender_id || $user->id === $chat->receiver_id;
    }

    public function delete(User $user, Chat $chat): bool
    {
        return $user->id === $chat->sender_id || $user->id === $chat->receiver_id;
    }
}
