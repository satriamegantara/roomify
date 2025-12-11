@extends('layouts.app')

@push('styles')
    @vite('resources/css/chat.css')
@endpush

@section('title', 'Pesan')

@section('content')
    <div class="chat-container">
        <!-- Header -->
        <div class="chat-header">
            <h1 class="header-title">
                <i class="bi bi-chat-dots"></i>Pesan
            </h1>
            <p class="header-subtitle">Komunikasi langsung dengan pemilik dan penyewa kos</p>
        </div>

        <div class="chat-wrapper">
            <!-- Conversations List -->
            <div class="conversations-panel">
                <div class="conversations-header">
                    <h2>Percakapan</h2>
                    <div class="search-box">
                        <input type="text" class="form-control" placeholder="Cari percakapan..." id="searchChat">
                        <i class="bi bi-search"></i>
                    </div>
                </div>

                <div class="conversations-list">
                    @if ($chats->count() > 0)
                        @php
                            // Group chats by conversation partner
                            $conversations = collect();
                            foreach ($chats as $chat) {
                                $partnerId = $chat->sender_id === auth()->id() ? $chat->receiver_id : $chat->sender_id;
                                $partner = $chat->sender_id === auth()->id() ? $chat->receiver : $chat->sender;

                                if (!$conversations->has($partnerId)) {
                                    $conversations->put($partnerId, (object) [
                                        'partner' => $partner,
                                        'lastMessage' => $chat,
                                        'unreadCount' => 0
                                    ]);
                                }

                                // Count unread messages from this partner
                                if ($chat->receiver_id === auth()->id() && !$chat->is_read) {
                                    $conversations[$partnerId]->unreadCount++;
                                }
                            }
                        @endphp

                        @foreach ($conversations as $partnerId => $conv)
                            <a href="{{ route('chat.show', $conv->lastMessage) }}" class="conversation-item">
                                <div class="conv-avatar">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($conv->partner->name) }}&background=10a37f&color=fff"
                                        alt="{{ $conv->partner->name }}" class="avatar">
                                    @if ($conv->unreadCount > 0)
                                        <span class="unread-badge">{{ $conv->unreadCount }}</span>
                                    @endif
                                </div>

                                <div class="conv-info">
                                    <div class="conv-header">
                                        <h3 class="conv-name">{{ $conv->partner->name }}</h3>
                                        <span class="conv-time">
                                            {{ $conv->lastMessage->created_at->diffForHumans() }}
                                        </span>
                                    </div>
                                    <p
                                        class="conv-message {{ !$conv->lastMessage->is_read && $conv->lastMessage->receiver_id === auth()->id() ? 'unread' : '' }}">
                                        @if ($conv->lastMessage->sender_id === auth()->id())
                                            <span class="sender-indicator">Anda: </span>
                                        @endif
                                        {{ Str::limit($conv->lastMessage->message, 50) }}
                                    </p>
                                </div>
                            </a>
                        @endforeach
                    @else
                        <div class="empty-state">
                            <div class="empty-icon">
                                <i class="bi bi-chat-left-dots"></i>
                            </div>
                            <h3 class="empty-title">Belum Ada Pesan</h3>
                            <p class="empty-text">Mulai percakapan dengan pemilik atau penyewa kos</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Chat Window -->
            <div class="chat-panel">
                <div class="chat-placeholder">
                    <div class="placeholder-icon">
                        <i class="bi bi-chat-quote"></i>
                    </div>
                    <h2>Pilih Percakapan</h2>
                    <p>Pilih percakapan dari daftar untuk memulai chat</p>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.getElementById('searchChat').addEventListener('input', function (e) {
                const query = e.target.value.toLowerCase();
                const items = document.querySelectorAll('.conversation-item');

                items.forEach(item => {
                    const name = item.querySelector('.conv-name').textContent.toLowerCase();
                    const message = item.querySelector('.conv-message').textContent.toLowerCase();

                    if (name.includes(query) || message.includes(query)) {
                        item.style.display = '';
                    } else {
                        item.style.display = 'none';
                    }
                });
            });
        </script>
    @endpush
@endsection