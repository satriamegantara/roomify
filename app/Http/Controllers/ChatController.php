<?php

namespace App\Http\Controllers;

use App\Models\Chat;
use App\Models\User;
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
        $user = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender;

        return view('chat.show', compact('messages', 'otherId', 'user'));
    }

    public function startChat(User $user)
    {
        // Find existing chat between current user and target user
        $existingChat = Chat::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', auth()->id());
        })->where('message', '!=', '')->latest()->first();

        if ($existingChat) {
            return redirect()->route('chat.show', $existingChat);
        }

        // Get first non-empty message or use placeholder for empty state
        $chat = Chat::where(function ($query) use ($user) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $user->id);
        })->orWhere(function ($query) use ($user) {
            $query->where('sender_id', $user->id)
                ->where('receiver_id', auth()->id());
        })->latest()->first();

        if (!$chat) {
            // Create placeholder chat for new conversation (empty message is OK)
            $chat = Chat::create([
                'sender_id' => auth()->id(),
                'receiver_id' => $user->id,
                'message' => ' ',
            ]);
        }

        return redirect()->route('chat.show', $chat);
    }

    public function send(Request $request)
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

        // Get the latest chat to redirect to show page
        $lastChat = Chat::where(function ($query) use ($validated) {
            $query->where('sender_id', auth()->id())
                ->where('receiver_id', $validated['receiver_id']);
        })->orWhere(function ($query) use ($validated) {
            $query->where('sender_id', $validated['receiver_id'])
                ->where('receiver_id', auth()->id());
        })->latest()->first();

        if ($request->expectsJson()) {
            return response()->json(['success' => true]);
        }

        return redirect()->route('chat.show', $lastChat);
    }
}
