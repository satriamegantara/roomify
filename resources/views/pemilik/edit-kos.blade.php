<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Edit Kos - Roomify</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/css/pemilik-dashboard.css', 'resources/css/pemilik-tambah-kos.css'])
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.11.1/font/bootstrap-icons.min.css">
</head>

<body>
    <!-- Sidebar -->
    <aside class="sidebar">
        <a href="{{ route('pemilik.dashboard') }}" class="sidebar-brand">
            <img src="{{ asset('assets/images/test.png') }}" alt="Roomify Logo" height="40"
                class="me-2 logo-img"><span>Roomify</span>
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
                <h1>Edit Kos</h1>
                <p>Perbarui informasi kos Anda</p>
            </div>
        </div>

        <!-- Content -->
        <div class="content-wrapper">
            <div class="form-container">
                <!-- Alert Messages -->
                @if ($errors->any())
                    <div
                        style="background-color: #fee2e2; border: 1px solid #fca5a5; border-radius: 8px; padding: 1rem; margin-bottom: 1.5rem; color: #991b1b;">
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

                <form action="{{ route('pemilik.kos.update', $kos->id) }}" method="POST" enctype="multipart/form-data"
                    id="formEditKos">
                    @csrf
                    @method('PUT')

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
                                <input type="text" id="alamat" name="alamat"
                                    placeholder="Jl. Contoh No. 123, Kota, Provinsi"
                                    value="{{ old('alamat', $kos->alamat) }}" required>
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
                                    <option value="putra" {{ old('jenis_kos', $kos->jenis_kos) == 'putra' ? 'selected' : '' }}>Kos Putra</option>
                                    <option value="putri" {{ old('jenis_kos', $kos->jenis_kos) == 'putri' ? 'selected' : '' }}>Kos Putri</option>
                                    <option value="campur" {{ old('jenis_kos', $kos->jenis_kos) == 'campur' ? 'selected' : '' }}>Kos Campuran</option>
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
                                    <input type="number" id="harga_bulanan" name="harga_bulanan" placeholder="500000"
                                        value="{{ old('harga_bulanan', $kos->harga_bulanan) }}" required min="0"
                                        step="1000">
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

                        <!-- Foto Utama Saat Ini -->
                        @if ($kos->foto_utama)
                            <div style="margin-bottom: 2rem;">
                                <label
                                    style="font-weight: 600; color: var(--dark); display: block; margin-bottom: 0.75rem;">
                                    Foto Utama Saat Ini
                                </label>
                                <div
                                    style="display: grid; grid-template-columns: repeat(auto-fill, minmax(120px, 1fr)); gap: 1rem;">
                                    <div class="image-preview">
                                        <img src="{{ asset('storage/' . $kos->foto_utama) }}" alt="Foto Utama">
                                        <button type="button" class="image-preview-remove" onclick="removeFotoUtama()">
                                            <i class="bi bi-x"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @endif

                        <div class="form-grid full">
                            <!-- Foto Utama Baru (Opsional) -->
                            <div class="form-group">
                                <label for="foto_utama">
                                    Ganti Foto Utama (Opsional)
                                </label>
                                <div class="file-upload">
                                    <input type="file" id="foto_utama" name="foto_utama" class="file-upload-input"
                                        accept="image/*">
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

                            <!-- Foto Lainnya Saat Ini -->
                            @if ($kos->foto_lainnya && count($kos->foto_lainnya) > 0)
                                <div class="form-group full">
                                    <label
                                        style="font-weight: 600; color: var(--dark); display: block; margin-bottom: 0.75rem;">
                                        Foto Tambahan Saat Ini
                                    </label>
                                    <div class="image-preview-container" id="currentPhotoLainnya">
                                        @foreach ($kos->foto_lainnya as $index => $foto)
                                            <div class="image-preview">
                                                <img src="{{ asset('storage/' . $foto) }}" alt="Foto Tambahan">
                                                <button type="button" class="image-preview-remove"
                                                    onclick="removeFotoLainnya({{ $index }})">
                                                    <i class="bi bi-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Foto Lainnya Baru -->
                            <div class="form-group full">
                                <label for="foto_lainnya">
                                    Tambah Foto Tambahan (Opsional)
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
                                    placeholder="Jelaskan fasilitas, kondisi, dan keunggulan kos Anda...">{{ old('deskripsi', $kos->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                    <span class="form-error">{{ $message }}</span>
                                @enderror
                                <span class="form-help">Tulis deskripsi yang menarik untuk menarik minat calon
                                    penghuni</span>
                            </div>
                        </div>
                    </div>

                    <!-- Section 4: Status (Jika Admin) -->
                    @if (Auth::user()->role === 'admin')
                        <div class="form-section">
                            <h2 class="form-section-title">
                                <i class="bi bi-shield-check"></i>
                                Status Kos
                            </h2>

                            <div class="form-grid">
                                <div class="form-group">
                                    <label for="status">
                                        Status
                                        <span class="required">*</span>
                                    </label>
                                    <select id="status" name="status" required>
                                        <option value="aktif" {{ old('status', $kos->status) == 'aktif' ? 'selected' : '' }}>
                                            Aktif</option>
                                        <option value="tidak_aktif" {{ old('status', $kos->status) == 'tidak_aktif' ? 'selected' : '' }}>Non-Aktif</option>
                                        <option value="penuh" {{ old('status', $kos->status) == 'penuh' ? 'selected' : '' }}>
                                            Penuh</option>
                                    </select>
                                    @error('status')
                                        <span class="form-error">{{ $message }}</span>
                                    @enderror
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Form Actions -->
                    <div class="form-actions">
                        <a href="{{ route('pemilik.kos.index') }}" class="btn-cancel">
                            <i class="bi bi-x-circle"></i>
                            <span>Batal</span>
                        </a>
                        <button type="submit" class="btn-submit">
                            <i class="bi bi-check-circle"></i>
                            <span>Simpan Perubahan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>

    <script>
        // Data foto lainnya yang ada
        let existingPhotos = {!! json_encode($kos->foto_lainnya ?? []) !!};

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

        function removeFotoUtama() {
            if (confirm('Apakah Anda yakin ingin menghapus foto utama?')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_foto_utama';
                input.value = '1';
                document.getElementById('formEditKos').appendChild(input);

                // Submit form
                document.getElementById('formEditKos').submit();
            }
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
                        <button type="button" class="image-preview-remove" onclick="removeFotoLainnyaPreview(${index})">
                            <i class="bi bi-x"></i>
                        </button>
                    `;
                    previewFotoLainnya.appendChild(preview);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFotoLainnyaPreview(index) {
            const dataTransfer = new DataTransfer();
            Array.from(inputFotoLainnya.files).forEach((file, i) => {
                if (i !== index) {
                    dataTransfer.items.add(file);
                }
            });
            inputFotoLainnya.files = dataTransfer.files;
            handleFotoLainnyaChange();
        }

        function removeFotoLainnya(index) {
            if (confirm('Apakah Anda yakin ingin menghapus foto ini?')) {
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_foto_lainnya[]';
                input.value = index;
                document.getElementById('formEditKos').appendChild(input);

                // Submit form
                document.getElementById('formEditKos').submit();
            }
        }

        // Currency format for price input
        const hargaBulananInput = document.getElementById('harga_bulanan');
        hargaBulananInput.addEventListener('input', function () {
            let value = this.value.replace(/\D/g, '');
            this.value = value;
        });

        // Form validation
        document.getElementById('formEditKos').addEventListener('submit', function (e) {
            const alamat = document.getElementById('alamat').value.trim();
            const jenisKos = document.getElementById('jenis_kos').value;
            const hargaBulanan = document.getElementById('harga_bulanan').value;

            if (!alamat || !jenisKos || !hargaBulanan) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi');
            }
        });
    </script>
</body>

</html>