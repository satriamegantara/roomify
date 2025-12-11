<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Pembayaran - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-pembayaran.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar Overlay -->
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
            <i class="bi bi-house-heart-fill"></i>
            <span>Roomify</span>
        </a>

        <ul class="sidebar-menu">
            <li>
                <a href="{{ route('pemilik.dashboard') }}">
                    <i class="bi bi-speedometer2"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.kos.index') }}">
                    <i class="bi bi-building"></i>
                    <span>Kelola Kos</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.bookings.index') }}">
                    <i class="bi bi-calendar-check"></i>
                    <span>Booking Masuk</span>
                </a>
            </li>
            <li>
                <a href="{{ route('pemilik.pembayaran.index') }}" class="active">
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
    <main class="payment-main">
        <!-- Header -->
        <div class="payment-header">
            <div class="payment-header-top">
                <div>
                    <h1 class="payment-title"><i class="bi bi-cash-stack me-2"></i>Pembayaran</h1>
                    <p class="payment-subtitle">Pantau pembayaran kos Anda, status, dan bukti transfer.</p>
                </div>
            </div>
        </div>

        <!-- Stats -->
        <div class="payment-stats">
            <div class="pay-card">
                <div class="label">Total Pembayaran</div>
                <div class="value">{{ $totalPembayaran }}</div>
            </div>
            <div class="pay-card pending">
                <div class="label">Pending</div>
                <div class="value">{{ $pendingCount }}</div>
            </div>
            <div class="pay-card lunas">
                <div class="label">Lunas</div>
                <div class="value">{{ $lunasCount }}</div>
            </div>
            <div class="pay-card terlambat">
                <div class="label">Terlambat</div>
                <div class="value">{{ $terlambatCount }}</div>
            </div>
            <div class="pay-card lunas">
                <div class="label">Total Diterima</div>
                <div class="value money">Rp {{ number_format($totalLunasAmount, 0, ',', '.') }}</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="payment-filters">
            <form action="{{ route('pemilik.pembayaran.index') }}" method="GET">
                <div class="filters-row">
                    <div>
                        <label class="filter-label">Status</label>
                        <select name="status" class="filter-select">
                            <option value="">Semua Status</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="lunas" {{ request('status') == 'lunas' ? 'selected' : '' }}>Lunas</option>
                            <option value="terlambat" {{ request('status') == 'terlambat' ? 'selected' : '' }}>Terlambat</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Metode</label>
                        <select name="metode" class="filter-select">
                            <option value="">Semua Metode</option>
                            <option value="transfer" {{ request('metode') == 'transfer' ? 'selected' : '' }}>Transfer</option>
                            <option value="tunai" {{ request('metode') == 'tunai' ? 'selected' : '' }}>Tunai</option>
                            <option value="e_wallet" {{ request('metode') == 'e_wallet' ? 'selected' : '' }}>E-Wallet</option>
                        </select>
                    </div>
                    <div>
                        <label class="filter-label">Cari Penyewa</label>
                        <input type="text" name="search" class="filter-input" placeholder="Nama penyewa" value="{{ request('search') }}">
                    </div>
                    <div>
                        <button type="submit" class="filter-btn"><i class="bi bi-funnel me-2"></i>Filter</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- Table -->
        <div class="payment-table-container">
            @if ($pembayarans->count() > 0)
                <table class="payment-table">
                    <thead>
                        <tr>
                            <th>Penyewa</th>
                            <th>Properti Kos</th>
                            <th>Periode</th>
                            <th>Metode</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Bukti</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pembayarans as $pay)
                            <tr>
                                <td>
                                    <div class="pay-info">
                                        <div class="pay-avatar">{{ strtoupper(substr($pay->penyewa->name, 0, 1)) }}</div>
                                        <div class="pay-details">
                                            <h4>{{ $pay->penyewa->name }}</h4>
                                            <p><i class="bi bi-envelope me-1"></i>{{ $pay->penyewa->email }}</p>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="pay-kos">{{ Str::limit($pay->kos->alamat, 32) }}</div>
                                    <div class="pay-address"><i class="bi bi-geo-alt me-1"></i>{{ Str::limit($pay->kos->alamat, 40) }}</div>
                                </td>
                                <td>
                                    {{ \Carbon\Carbon::parse($pay->bulan_tahun)->translatedFormat('F Y') }}
                                </td>
                                <td>
                                    <span class="pay-method">
                                        @switch($pay->metode)
                                            @case('transfer')
                                                <i class="bi bi-bank"></i>
                                                @break
                                            @case('tunai')
                                                <i class="bi bi-cash"></i>
                                                @break
                                            @case('e_wallet')
                                                <i class="bi bi-phone"></i>
                                                @break
                                        @endswitch
                                        {{ ucfirst(str_replace('_', ' ', $pay->metode)) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="pay-amount {{ $pay->status === 'lunas' ? 'lunas' : '' }}">
                                        Rp {{ number_format($pay->jumlah, 0, ',', '.') }}
                                    </span>
                                </td>
                                <td>
                                    <span class="pay-status {{ $pay->status }}">
                                        @switch($pay->status)
                                            @case('pending')
                                                <i class="bi bi-clock"></i>
                                                @break
                                            @case('lunas')
                                                <i class="bi bi-check2-circle"></i>
                                                @break
                                            @case('terlambat')
                                                <i class="bi bi-exclamation-octagon"></i>
                                                @break
                                        @endswitch
                                        {{ ucfirst($pay->status) }}
                                    </span>
                                </td>
                                <td>
                                    <div class="pay-actions">
                                        @if ($pay->bukti_transfer)
                                            <a class="pay-btn view" href="{{ asset('storage/' . $pay->bukti_transfer) }}" target="_blank" rel="noopener">
                                                <i class="bi bi-eye"></i>
                                            </a>
                                            <a class="pay-btn download" href="{{ asset('storage/' . $pay->bukti_transfer) }}" download>
                                                <i class="bi bi-download"></i>
                                            </a>
                                        @else
                                            <span style="color: var(--text-muted); font-size: 0.85rem;">Tidak ada</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <div class="pay-pagination">
                    {{ $pembayarans->links() }}
                </div>
            @else
                <div class="pay-empty">
                    <div class="icon"><i class="bi bi-wallet2"></i></div>
                    <h4 style="font-weight: 700; color: var(--dark);">Belum ada pembayaran</h4>
                    <p style="color: var(--text-muted);">Pembayaran akan tampil di sini ketika penyewa melakukan pembayaran.</p>
                </div>
            @endif
        </div>
    </main>

    @vite(['resources/js/app.js'])

    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const sidebarOverlay = document.getElementById('sidebarOverlay');

        function toggleSidebar() {
            sidebar.classList.toggle('active');
            sidebarOverlay.classList.toggle('active');
            document.body.style.overflow = sidebar.classList.contains('active') ? 'hidden' : '';
        }

        mobileMenuToggle.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebarOverlay.addEventListener('click', function (e) {
            e.stopPropagation();
            toggleSidebar();
        });

        sidebar.addEventListener('click', function (e) {
            e.stopPropagation();
        });

        if (window.innerWidth <= 768) {
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-menu a');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', function () {
                    if (!this.closest('form')) {
                        toggleSidebar();
                    }
                });
            });
        }
    </script>
</body>

</html>
