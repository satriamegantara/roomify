@extends('layouts.app')

@push('styles')
    @vite('resources/css/chat.css')
@endpush

@section('title', 'Chat')

@section('content')
    <div class="chat-container">
        <!-- Chat Header with User Info -->
        <div class="chat-top">
            <div class="chat-user-header">
                <a href="{{ route('chat.index') }}" class="back-btn" title="Kembali">
                    <i class="bi bi-chevron-left"></i>
                </a>
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10a37f&color=fff"
                    alt="{{ $user->name }}" class="user-avatar">
                <div class="user-info">
                    <h2 class="user-name">{{ $user->name }}</h2>
                    <p class="user-role">
                        @if ($user->role === 'pemilik')
                            <i class="bi bi-house"></i>Pemilik Kos
                        @elseif ($user->role === 'penyewa')
                            <i class="bi bi-person-check"></i>Penyewa
                        @else
                            <i class="bi bi-person"></i>{{ ucfirst($user->role) }}
                        @endif
                    </p>
                </div>
            </div>

            <div class="chat-actions">
                <button class="icon-btn" title="Informasi" data-bs-toggle="offcanvas" data-bs-target="#chatInfo">
                    <i class="bi bi-info-circle"></i>
                </button>
            </div>
        </div>

        <!-- Messages Area -->
        <div class="messages-area" id="messagesArea">
            @forelse ($messages as $message)
                @if (trim($message->message) !== '')
                    <div class="message {{ $message->sender_id === auth()->id() ? 'sent' : 'received' }}">
                        @if ($message->sender_id !== auth()->id())
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10a37f&color=fff"
                                alt="{{ $user->name }}" class="message-avatar">
                        @endif

                        <div class="message-content">
                            <div class="message-bubble">
                                {{ $message->message }}
                            </div>
                            <span class="message-time">{{ $message->created_at->format('H:i') }}</span>
                        </div>
                    </div>
                @endif
            @empty
                <div class="empty-messages">
                    <div class="empty-icon">
                        <i class="bi bi-chat-left"></i>
                    </div>
                    <h3>Mulai Percakapan</h3>
                    <p>Belum ada pesan. Kirim pesan pertama Anda sekarang!</p>
                </div>
            @endforelse
        </div>

        <!-- Message Input -->
        <div class="message-input-area">
            <form action="{{ route('chat.send') }}" method="POST" id="messageForm">
                @csrf
                <input type="hidden" name="receiver_id" value="{{ $otherId }}">

                <div class="input-group">
                    <textarea name="message" class="form-control message-input" placeholder="Ketik pesan..." rows="1"
                        required></textarea>
                    <button type="submit" class="btn-send" title="Kirim">
                        <i class="bi bi-send-fill"></i>
                    </button>
                </div>

                @error('message')
                    <small class="text-danger d-block mt-2">{{ $message }}</small>
                @enderror
            </form>
        </div>
    </div>

    <!-- Chat Info Offcanvas -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="chatInfo">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Informasi Pengguna</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas"></button>
        </div>
        <div class="offcanvas-body">
            <div class="user-card">
                <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=10a37f&color=fff"
                    alt="{{ $user->name }}" class="profile-img">
                <h3 class="mt-3">{{ $user->name }}</h3>
                <p class="text-muted">{{ $user->email }}</p>

                <hr>

                <h6 class="mb-3">Informasi Kontak</h6>
                <div class="info-item">
                    <span class="info-label">Email</span>
                    <span class="info-value">{{ $user->email }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Telepon</span>
                    <span class="info-value">{{ $user->phone ?? 'Tidak tersedia' }}</span>
                </div>

                <div class="info-item">
                    <span class="info-label">Peran</span>
                    <span class="info-value">
                        @if ($user->role === 'pemilik')
                            Pemilik Kos
                        @elseif ($user->role === 'penyewa')
                            Penyewa
                        @else
                            {{ ucfirst($user->role) }}
                        @endif
                    </span>
                </div>

                <hr>

                <a href="{{ route('profile.edit') }}" class="btn btn-primary-kosan w-100">
                    <i class="bi bi-person-circle me-2"></i>Lihat Profil
                </a>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            // Auto-scroll to bottom
            const messagesArea = document.getElementById('messagesArea');
            if (messagesArea) {
                messagesArea.scrollTop = messagesArea.scrollHeight;
            }

            // Auto-expand textarea
            const messageInput = document.querySelector('.message-input');
            if (messageInput) {
                messageInput.addEventListener('input', function () {
                    this.style.height = 'auto';
                    this.style.height = Math.min(this.scrollHeight, 120) + 'px';
                });
            }

            // Submit form with Enter key
            document.getElementById('messageForm').addEventListener('keypress', function (e) {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.submit();
                }
            });

            // Auto-refresh messages every 2 seconds
            setInterval(function () {
                fetch(window.location.href, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                })
                    .then(response => response.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const newDoc = parser.parseFromString(html, 'text/html');
                        const newMessages = newDoc.querySelector('#messagesArea');

                        if (newMessages && newMessages.innerHTML !== messagesArea.innerHTML) {
                            messagesArea.innerHTML = newMessages.innerHTML;
                            messagesArea.scrollTop = messagesArea.scrollHeight;
                        }
                    });
            }, 2000);
        </script>
    @endpush
@endsection