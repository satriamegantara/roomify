<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Kelola Kos - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-kos.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">

</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-house-heart-fill"></i>
            <span>Roomify</span>
        </a>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('pemilik.dashboard') }}"
                    class="{{ request()->routeIs('pemilik.dashboard') ? 'active' : '' }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.kos.index') }}"
                    class="{{ request()->routeIs('pemilik.kos.*') ? 'active' : '' }}">
                    <i class="bi bi-building"></i>
                    <span>Kelola Kos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.bookings.index') }}"
                    class="{{ request()->routeIs('pemilik.bookings.*') ? 'active' : '' }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.pembayaran.index') }}"
                    class="{{ request()->routeIs('pemilik.pembayaran.*') ? 'active' : '' }}">
                    <i class="bi bi-cash-stack"></i>
                    <span>Pembayaran</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('chat.index') }}">
                    <i class="bi bi-chat-dots"></i>
                    <span>Pesan</span>
                </a>
            </li>
            <li>
                <a href="{{ route('profile.edit') }}">
                    <i class="bi bi-person-circle"></i>
                    <span>Profil Saya</span>
                </a>
            </li>
            <li>
                <a href="{{ route('home') }}">
                    <i class="bi bi-globe"></i>
                    <span>Lihat Website</span>
                </a>
            </li>
        </ul>

        <div class="sidebar-divider"></div>

        <ul class="sidebar-menu">
            <li>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <a href="#" onclick="event.preventDefault(); this.closest('form').submit();">
                        <i class="bi bi-box-arrow-right"></i>
                        <span>Logout</span>
                    </a>
                </form>
            </li>
        </ul>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <!-- Top Bar -->
        <div class="top-bar">
            <div class="top-bar-title">
                <h1>Kelola Kos</h1>
                <p>Atur dan pantau semua kos yang Anda tawarkan</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <!-- Top Actions -->
            <div class="top-actions">
                <div class="search-box">
                    <input type="text" id="searchKos" placeholder="Cari kos...">
                </div>
                <div class="filter-group">
                    <button class="filter-btn active" data-filter="all">Semua</button>
                    <button class="filter-btn" data-filter="aktif">Aktif</button>
                    <button class="filter-btn" data-filter="tidak_aktif">Non-Aktif</button>
                    <button class="filter-btn" data-filter="penuh">Penuh</button>
                </div>
                <a href="{{ route('pemilik.kos.create') }}" class="btn-add-kos">
                    <i class="bi bi-plus-circle"></i>
                    <span>Tambah Kos</span>
                </a>
            </div>

            <!-- Kos List -->
            @if ($kos->count() > 0)
                <div class="kos-container" id="kosContainer">
                    @foreach ($kos as $item)
                        <div class="kos-card" data-status="{{ $item->status }}" data-name="{{ strtolower($item->alamat) }}">
                            <!-- Image -->
                            @if ($item->foto_utama)
                                <img src="{{ asset('storage/' . $item->foto_utama) }}" alt="{{ $item->alamat }}"
                                    class="kos-card-image">
                            @else
                                <div class="kos-card-image-placeholder">
                                    <i class="bi bi-image"></i>
                                </div>
                            @endif

                            <!-- Header -->
                            <div class="kos-card-header">
                                <h3 class="kos-card-title">{{ Str::limit($item->alamat, 30) }}</h3>

                                <p class="kos-card-address">
                                    <i class="bi bi-geo-alt-fill"></i>
                                    {{ Str::limit($item->alamat, 40) }}
                                </p>

                                <!-- Meta Info -->
                                <div class="kos-card-meta">
                                    <div class="kos-meta-item">
                                        <i class="bi bi-door-closed"></i>
                                        <span>{{ $item->jenis_kos }}</span>
                                    </div>
                                    <div class="kos-meta-item">
                                        <i class="bi bi-calendar-event"></i>
                                        <span>Bulanan</span>
                                    </div>
                                </div>

                                <!-- Rating -->
                                <div class="kos-card-rating">
                                    <div class="stars">
                                        @for ($i = 0; $i < floor($item->getAverageRating()); $i++)
                                            <i class="bi bi-star-fill"></i>
                                        @endfor
                                        @if ($item->getAverageRating() - floor($item->getAverageRating()) >= 0.5)
                                            <i class="bi bi-star-half"></i>
                                        @endif
                                        <span style="margin-left: 0.5rem; color: #6b7280;">
                                            {{ number_format($item->getAverageRating(), 1) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Status -->
                                @if ($item->status === 'aktif')
                                    <span class="kos-card-status aktif">Aktif</span>
                                @elseif ($item->status === 'tidak_aktif')
                                    <span class="kos-card-status inactive">Non-Aktif</span>
                                @elseif ($item->status === 'penuh')
                                    <span class="kos-card-status pending">Penuh</span>
                                @else
                                    <span class="kos-card-status pending">{{ ucfirst($item->status) }}</span>
                                @endif

                                <!-- Price -->
                                <div class="kos-card-price">
                                    Rp{{ number_format($item->harga_bulanan, 0, ',', '.') }}
                                </div>
                            </div>

                            <!-- Footer / Actions -->
                            <div class="kos-card-footer">
                                <a href="{{ route('pemilik.kos.edit', $item->id) }}" class="btn-action primary">
                                    <i class="bi bi-pencil-square"></i>
                                    <span>Edit</span>
                                </a>
                                <button class="btn-action secondary" onclick="viewKosDetail({{ $item->id }}, event)">
                                    <i class="bi bi-eye"></i>
                                    <span>Lihat</span>
                                </button>
                                <button class="btn-action danger" onclick="deleteKos({{ $item->id }}, event)">
                                    <i class="bi bi-trash"></i>
                                    <span>Hapus</span>
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="empty-state">
                    <div class="empty-state-icon">
                        <i class="bi bi-building"></i>
                    </div>
                    <h3 class="empty-state-title">Belum Ada Kos</h3>
                    <p class="empty-state-text">Mulai daftarkan kos Anda sekarang untuk menerima booking dari calon penghuni
                    </p>
                    <a href="{{ route('pemilik.kos.create') }}" class="btn-add-kos">
                        <i class="bi bi-plus-circle"></i>
                        <span>Tambah Kos Pertama</span>
                    </a>
                </div>
            @endif
        </div>
    </main>

    <script>
        // Filter functionality
        const filterButtons = document.querySelectorAll('.filter-btn');
        const kosCards = document.querySelectorAll('.kos-card');
        const searchInput = document.getElementById('searchKos');

        filterButtons.forEach(button => {
            button.addEventListener('click', function () {
                // Update active button
                filterButtons.forEach(btn => btn.classList.remove('active'));
                this.classList.add('active');

                // Filter cards
                const filter = this.getAttribute('data-filter');
                kosCards.forEach(card => {
                    const status = card.getAttribute('data-status');
                    if (filter === 'all' || status === filter) {
                        card.style.display = 'flex';
                    } else {
                        card.style.display = 'none';
                    }
                });
            });
        });

        // Search functionality
        searchInput?.addEventListener('input', function () {
            const searchTerm = this.value.toLowerCase();
            kosCards.forEach(card => {
                const name = card.getAttribute('data-name');
                if (name.includes(searchTerm)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Modal functions

        function viewKosDetail(kosId, event) {
            event.preventDefault();
            // Redirect ke halaman detail kos
            window.location.href = `/kos/${kosId}`;
        }

        function deleteKos(kosId, event) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus kos ini? Tindakan ini tidak dapat dibatalkan.')) {
                alert('Fitur delete akan diimplementasikan. Kos ID: ' + kosId);
                // Implementasi delete via AJAX
            }
        }
    </script>
</body>

</html>