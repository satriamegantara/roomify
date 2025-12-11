<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ChatController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(): View
    {
        $chats = Chat::where('sender_id', auth()->id())
            ->orWhere('receiver_id', auth()->id())
            ->with('sender', 'receiver')
            ->distinct()
            ->latest()
            ->get();

        return view('chat.index', compact('chats'));
    }

    public function show(Chat $chat): View
    {
        $this->authorize('view', $chat);

        $messages = Chat::where(function ($query) use ($chat) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $chat->sender_id === auth()->id() ? $chat->receiver_id : $chat->sender_id);
        })->orWhere(function ($query) use ($chat) {
            $query->where('sender_id', $chat->sender_id === auth()->id() ? $chat->receiver_id : $chat->sender_id)
                ->where('receiver_id', auth()->id());
        })->oldest()->get();

        $otherId = $chat->sender_id === auth()->id() ? $chat->receiver_id : $chat->sender_id;

        return view('chat.show', compact('messages', 'otherId'));
    }

    public function send(Request $request): \Illuminate\Http\JsonResponse
    {
        $validated = $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:1000',
        ]);

        Chat::create([
            'sender_id' => auth()->id(),
            'receiver_id' => $validated['receiver_id'],
            'message' => $validated['message'],
        ]);

        return response()->json(['success' => true]);
    }
}
