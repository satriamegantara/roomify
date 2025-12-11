<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Tambah Kos - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-tambah-kos.css'])
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
                <h1>Tambah Kos Baru</h1>
                <p>Daftarkan kos Anda dan mulai terima booking</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="form-container">
                <!-- Alert Messages -->
                @if ($errors->any())
                    <div style="background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #991b1b;">
                        <div style="font-weight: 600; margin-bottom: 0.5rem;">
                            <i class="bi bi-exclamation-circle"></i> Ada kesalahan dalam formulir
                        </div>
                        <ul style="margin: 0; padding-left: 1.5rem;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('pemilik.kos.store') }}" method="POST" enctype="multipart/form-data" id="formTambahKos">
                    @csrf

                    <!-- Section 1: Informasi Dasar -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="bi bi-info-circle"></i>
                            Informasi Dasar Kos
                        </h2>

                        <div class="form-grid">
                            <!-- Alamat -->
                            <div class="form-group full">
                                <label for="alamat">
                                    Alamat Lengkap
                                    <span class="required">*</span>
                                </label>
                                <input type="text" id="alamat" name="alamat" placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                                    value="{{ old('alamat') }}" required>
                                @error('alamat')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <span class="form-help">Masukkan alamat lengkap kos yang jelas dan terperinci</span>
                            </div>

                            <!-- Jenis Kos -->
                            <div class="form-group">
                                <label for="jenis_kos">
                                    Jenis Kos
                                    <span class="required">*</span>
                                </label>
                                <select id="jenis_kos" name="jenis_kos" required>
                                    <option value="">-- Pilih Jenis Kos --</option>
                                    <option value="putra" {{ old('jenis_kos') == 'putra' ? 'selected' : '' }}>Kos Putra</option>
                                    <option value="putri" {{ old('jenis_kos') == 'putri' ? 'selected' : '' }}>Kos Putri</option>
                                    <option value="campur" {{ old('jenis_kos') == 'campur' ? 'selected' : '' }}>Kos Campuran</option>
                                </select>
                                @error('jenis_kos')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Harga Bulanan -->
                            <div class="form-group">
                                <label for="harga_bulanan">
                                    Harga Bulanan
                                    <span class="required">*</span>
                                </label>
                                <div class="input-group">
                                    <span class="input-group-prefix">Rp</span>
                                    <input type="number" id="harga_bulanan" name="harga_bulanan"
                                        placeholder="500000" value="{{ old('harga_bulanan') }}" required
                                        min="0" step="1000">
                                </div>
                                @error('harga_bulanan')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <span class="form-help">Harga sewa per bulan</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 2: Foto -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="bi bi-image"></i>
                            Foto Kos
                        </h2>

                        <div class="form-grid full">
                            <!-- Foto Utama -->
                            <div class="form-group">
                                <label for="foto_utama">
                                    Foto Utama
                                    <span class="required">*</span>
                                </label>
                                <div class="file-upload">
                                    <input type="file" id="foto_utama" name="foto_utama" class="file-upload-input"
                                        accept="image/*" required>
                                    <label for="foto_utama" class="file-upload-label" id="labelFotoUtama">
                                        <div class="file-upload-content">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <div class="file-upload-text">
                                                <strong>Klik untuk upload</strong> atau drag and drop
                                                <br>
                                                <small>PNG, JPG, GIF hingga 5MB</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('foto_utama')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <div id="previewFotoUtama" class="image-preview-container" style="display: none;"></div>
                            </div>

                            <!-- Foto Lainnya -->
                            <div class="form-group">
                                <label for="foto_lainnya">
                                    Foto Tambahan (Opsional)
                                </label>
                                <div class="file-upload">
                                    <input type="file" id="foto_lainnya" name="foto_lainnya[]" class="file-upload-input"
                                        accept="image/*" multiple>
                                    <label for="foto_lainnya" class="file-upload-label" id="labelFotoLainnya">
                                        <div class="file-upload-content">
                                            <i class="bi bi-cloud-arrow-up"></i>
                                            <div class="file-upload-text">
                                                <strong>Klik untuk upload</strong> atau drag and drop
                                                <br>
                                                <small>Bisa upload multiple foto</small>
                                            </div>
                                        </div>
                                    </label>
                                </div>
                                @error('foto_lainnya')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <div id="previewFotoLainnya" class="image-preview-container"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Section 3: Deskripsi -->
                    <div class="form-section">
                        <h2 class="form-section-title">
                            <i class="bi bi-file-text"></i>
                            Deskripsi Kos (Opsional)
                        </h2>

                        <div class="form-grid full">
                            <div class="form-group">
                                <label for="deskripsi">Deskripsi Lengkap</label>
                                <textarea id="deskripsi" name="deskripsi"
                                    placeholder="Jelaskan fasilitas, kondisi, dan keunggulan kos Anda...">{{ old('deskripsi') }}</textarea>
                                @error('deskripsi')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <span class="form-help">Tulis deskripsi yang menarik untuk menarik minat calon penghuni</span>
                            </div>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('pemilik.kos.index') }}" class="btn-cancel">
                            <i class="bi bi-x-circle"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle"></i>
                            <span>Simpan Kos</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Drag and drop for main photo
        const labelFotoUtama = document.getElementById('labelFotoUtama');
        const inputFotoUtama = document.getElementById('foto_utama');
        const previewFotoUtama = document.getElementById('previewFotoUtama');

        labelFotoUtama.addEventListener('dragover', (e) => {
            e.preventDefault();
            labelFotoUtama.classList.add('dragover');
        });

        labelFotoUtama.addEventListener('dragleave', () => {
            labelFotoUtama.classList.remove('dragover');
        });

        labelFotoUtama.addEventListener('drop', (e) => {
            e.preventDefault();
            labelFotoUtama.classList.remove('dragover');
            const files = e.dataTransfer.files;
            inputFotoUtama.files = files;
            handleFotoUtamaChange();
        });

        inputFotoUtama.addEventListener('change', handleFotoUtamaChange);

        function handleFotoUtamaChange() {
            const file = inputFotoUtama.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = (e) => {
                    previewFotoUtama.innerHTML = `
                        <div class="image-preview">
                            <img src="${e.target.result}" alt="Preview">
                            <button type="button" class="image-preview-remove" onclick="clearFotoUtama()">
                                <i class="bi bi-x"></i>
                            </button>
                        </div>
                    `;
                    previewFotoUtama.style.display = 'grid';
                };
                reader.readAsDataURL(file);
            }
        }

        function clearFotoUtama() {
            inputFotoUtama.value = '';
            previewFotoUtama.innerHTML = '';
            previewFotoUtama.style.display = 'none';
        }

        // Drag and drop for additional photos
        const labelFotoLainnya = document.getElementById('labelFotoLainnya');
        const inputFotoLainnya = document.getElementById('foto_lainnya');
        const previewFotoLainnya = document.getElementById('previewFotoLainnya');

        labelFotoLainnya.addEventListener('dragover', (e) => {
            e.preventDefault();
            labelFotoLainnya.classList.add('dragover');
        });

        labelFotoLainnya.addEventListener('dragleave', () => {
            labelFotoLainnya.classList.remove('dragover');
        });

        labelFotoLainnya.addEventListener('drop', (e) => {
            e.preventDefault();
            labelFotoLainnya.classList.remove('dragover');
            const files = e.dataTransfer.files;
            inputFotoLainnya.files = files;
            handleFotoLainnyaChange();
        });

        inputFotoLainnya.addEventListener('change', handleFotoLainnyaChange);

        function handleFotoLainnyaChange() {
            const files = inputFotoLainnya.files;
            previewFotoLainnya.innerHTML = '';

            Array.from(files).forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const preview = document.createElement('div');
                    preview.className = 'image-preview';
                    preview.innerHTML = `
                        <img src="${e.target.result}" alt="Preview">
                        <button type="button" class="image-preview-remove" onclick="removeFotoLainnya(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                    previewFotoLainnya.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFotoLainnya(index) {
            const dataTransfer = new DataTransfer();
            Array.from(inputFotoLainnya.files).forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            inputFotoLainnya.files = dataTransfer.files;
            handleFotoLainnyaChange();
        }

        // Currency format for price input
        const hargaBulananInput = document.getElementById('harga_bulanan');
        hargaBulananInput.addEventListener('input', function() {
            let value = this.value.replace(/\D/g, '');
            this.value = value;
        });

        // Form validation
        document.getElementById('formTambahKos').addEventListener('submit', function(e) {
            const fotoUtama = inputFotoUtama.files.length;
            const alamat = document.getElementById('alamat').value.trim();
            const jenisKos = document.getElementById('jenis_kos').value;
            const hargaBulanan = document.getElementById('harga_bulanan').value;

            if (!alamat || !jenisKos || !hargaBulanan || fotoUtama === 0) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
            }
        });
    </script>
</body>

</html>
