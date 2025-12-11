@extends('layouts.app')

@section('title', 'Detail Pembayaran - Roomify')

@section('content')
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb" class="mb-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('pembayaran.index') }}" class="text-decoration-none">
                    <i class="bi bi-arrow-left me-1"></i>Riwayat Pembayaran
                </a>
            </li>
            <li class="breadcrumb-item active">Detail Pembayaran</li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="row mb-4">
        <div class="col">
            <h1 class="h3 fw-bold mb-1">Detail Pembayaran</h1>
            <p class="text-muted mb-0">{{ $pembayaran->bulan_tahun->format('F Y') }}</p>
        </div>
        <div class="col-auto">
            <span class="badge badge-{{ $pembayaran->status }} fs-6">
                @if ($pembayaran->status === 'pending')
                    <i class="bi bi-hourglass-split me-2"></i>Menunggu Verifikasi
                @elseif ($pembayaran->status === 'lunas')
                    <i class="bi bi-check-circle me-2"></i>Sudah Lunas
                @else
                    <i class="bi bi-exclamation-triangle me-2"></i>Terlambat
                @endif
            </span>
        </div>
    </div>

    <!-- Alert -->
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="bi bi-check-circle me-2"></i>{{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif

    <div class="row g-4">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Pembayaran Information Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Informasi Pembayaran</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Kos</label>
                            <p class="fw-bold">{{ $pembayaran->kos->nama }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Periode</label>
                            <p class="fw-bold">{{ $pembayaran->bulan_tahun->format('F Y') }}</p>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Metode Pembayaran</label>
                            <p class="fw-bold">
                                @if ($pembayaran->metode === 'transfer')
                                    <i class="bi bi-bank text-primary me-2"></i>Transfer Bank
                                @elseif ($pembayaran->metode === 'tunai')
                                    <i class="bi bi-cash-coin text-success me-2"></i>Tunai
                                @else
                                    <i class="bi bi-phone text-info me-2"></i>E-Wallet
                                @endif
                            </p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Jumlah Pembayaran</label>
                            <p class="fw-bold h5 text-primary mb-0">
                                Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Tanggal Pembayaran</label>
                            <p class="fw-bold">{{ $pembayaran->created_at->format('d M Y H:i') }}</p>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Status</label>
                            <p class="fw-bold">
                                @if ($pembayaran->status === 'pending')
                                    <span class="badge bg-warning">Menunggu Verifikasi</span>
                                @elseif ($pembayaran->status === 'lunas')
                                    <span class="badge bg-success">Sudah Lunas</span>
                                @else
                                    <span class="badge bg-danger">Terlambat</span>
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Kos Details Card -->
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Detail Kos</h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center mb-3">
                            @if ($pembayaran->kos->foto_utama)
                                <img src="{{ asset('storage/' . $pembayaran->kos->foto_utama) }}" alt="Kos"
                                    class="img-fluid rounded" style="max-height: 200px; object-fit: cover;">
                            @else
                                <img src="https://via.placeholder.com/200" alt="Kos" class="img-fluid rounded"
                                    style="max-height: 200px; object-fit: cover;">
                            @endif
                        </div>
                        <div class="col-md-8">
                            <h6 class="fw-bold mb-2">{{ $pembayaran->kos->nama }}</h6>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-geo-alt-fill me-2"></i>{{ $pembayaran->kos->alamat }}
                            </p>
                            <p class="text-muted small mb-2">
                                <i class="bi bi-person-badge me-2"></i>
                                @if ($pembayaran->kos->jenis_kos === 'putra')
                                    Kos Putra
                                @elseif ($pembayaran->kos->jenis_kos === 'putri')
                                    Kos Putri
                                @else
                                    Kos Campur
                                @endif
                            </p>
                            <p class="text-muted small">
                                <i class="bi bi-cash-circle me-2"></i>
                                Rp {{ number_format($pembayaran->kos->harga_bulanan, 0, ',', '.') }}/bulan
                            </p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Upload Bukti Pembayaran -->
            @if ($pembayaran->status === 'pending' && !$pembayaran->bukti_transfer)
                <div class="card shadow-sm border-0 mb-4 border-warning border">
                    <div class="card-header bg-warning bg-opacity-10 border-warning py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-exclamation-triangle me-2 text-warning"></i>Upload Bukti Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="text-muted mb-3">
                            Silakan upload bukti transfer atau pembayaran untuk verifikasi pembayaran Anda.
                        </p>

                        <form action="{{ route('pembayaran.uploadBukti', $pembayaran) }}" method="POST"
                            enctype="multipart/form-data" id="uploadForm">
                            @csrf
                            <div class="upload-area" id="uploadArea">
                                <i class="bi bi-cloud-arrow-up"></i>
                                <h6 class="mt-3">Drag & drop bukti pembayaran di sini</h6>
                                <p class="text-muted small">atau klik untuk memilih file</p>
                                <input type="file" name="bukti_transfer" id="bukti_transfer" accept="image/*" hidden>
                            </div>

                            <div id="fileInfo" class="mt-3" style="display: none;">
                                <div class="alert alert-info">
                                    <i class="bi bi-info-circle me-2"></i>
                                    File: <span id="fileName"></span> (<span id="fileSize"></span>)
                                </div>
                            </div>

                            @error('bukti_transfer')
                                <div class="alert alert-danger mt-3">
                                    <i class="bi bi-exclamation-triangle me-2"></i>{{ $message }}
                                </div>
                            @enderror

                            <button type="submit" class="btn btn-primary mt-3" id="submitBtn" style="display: none;">
                                <i class="bi bi-upload me-2"></i>Upload Bukti
                            </button>
                        </form>
                    </div>
                </div>
            @elseif ($pembayaran->bukti_transfer)
                <div class="card shadow-sm border-0 mb-4 border-success border">
                    <div class="card-header bg-success bg-opacity-10 border-success py-3">
                        <h5 class="fw-bold mb-0">
                            <i class="bi bi-check-circle me-2 text-success"></i>Bukti Pembayaran
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="text-center">
                            <img src="{{ asset('storage/' . $pembayaran->bukti_transfer) }}" alt="Bukti Transfer"
                                class="img-fluid rounded" style="max-height: 400px;">
                        </div>
                        <div class="mt-3">
                            <a href="{{ asset('storage/' . $pembayaran->bukti_transfer) }}"
                                class="btn btn-sm btn-outline-primary" download>
                                <i class="bi bi-download me-2"></i>Download
                            </a>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Summary Card -->
            <div class="card shadow-sm border-0 mb-4 sticky-top" style="top: 80px;">
                <div class="card-header bg-white border-0 py-3">
                    <h5 class="fw-bold mb-0">Ringkasan</h5>
                </div>
                <div class="card-body">
                    <div class="summary-item mb-3">
                        <span class="text-muted">Jumlah Pembayaran</span>
                        <h6 class="fw-bold">Rp {{ number_format($pembayaran->jumlah, 0, ',', '.') }}</h6>
                    </div>

                    <hr>

                    <div class="summary-item mb-3">
                        <span class="text-muted">Status Pembayaran</span>
                        <div class="mt-2">
                            @if ($pembayaran->status === 'pending')
                                <span class="badge bg-warning w-100 py-2">
                                    <i class="bi bi-hourglass-split me-2"></i>Menunggu Verifikasi
                                </span>
                            @elseif ($pembayaran->status === 'lunas')
                                <span class="badge bg-success w-100 py-2">
                                    <i class="bi bi-check-circle me-2"></i>Sudah Lunas
                                </span>
                            @else
                                <span class="badge bg-danger w-100 py-2">
                                    <i class="bi bi-exclamation-triangle me-2"></i>Terlambat
                                </span>
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="summary-item">
                        <span class="text-muted">Metode Pembayaran</span>
                        <p class="fw-bold mb-0">
                            @if ($pembayaran->metode === 'transfer')
                                Transfer Bank
                            @elseif ($pembayaran->metode === 'tunai')
                                Tunai
                            @else
                                E-Wallet
                            @endif
                        </p>
                    </div>
                </div>

                <div class="card-footer bg-white border-0 py-3">
                    <a href="{{ route('pembayaran.index') }}" class="btn btn-outline-primary w-100">
                        <i class="bi bi-arrow-left me-2"></i>Kembali
                    </a>
                </div>
            </div>

            <!-- Info Card -->
            <div class="card shadow-sm border-0 bg-light">
                <div class="card-body">
                    <h6 class="fw-bold mb-3">
                        <i class="bi bi-info-circle me-2 text-info"></i>Informasi Penting
                    </h6>
                    <ul class="list-unstyled small text-muted">
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Pastikan upload bukti dengan jelas dan lengkap
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            File yang diterima: JPG, PNG, PDF (max 2MB)
                        </li>
                        <li class="mb-2">
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Verifikasi biasanya selesai dalam 24 jam
                        </li>
                        <li>
                            <i class="bi bi-check-circle text-success me-2"></i>
                            Hubungi admin jika ada pertanyaan
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <!-- Status Badge Colors CSS -->
    <style>
        .badge-pending {
            background-color: #fef3c7;
            color: #92400e;
        }

        .badge-lunas {
            background-color: #ecfdf5;
            color: #065f46;
        }

        .badge-terlambat {
            background-color: #fef2f2;
            color: #991b1b;
        }

        /* Upload Area */
        .upload-area {
            border: 2px dashed #10a37f;
            border-radius: 12px;
            padding: 3rem 2rem;
            text-align: center;
            cursor: pointer;
            transition: all 0.3s ease;
            background: linear-gradient(135deg, rgba(16, 163, 127, 0.05) 0%, rgba(16, 163, 127, 0.02) 100%);
        }

        .upload-area:hover {
            background: linear-gradient(135deg, rgba(16, 163, 127, 0.1) 0%, rgba(16, 163, 127, 0.05) 100%);
            border-color: #059669;
        }

        .upload-area i {
            font-size: 3rem;
            color: #10a37f;
        }

        .upload-area h6 {
            color: #1f2937;
            font-weight: 600;
        }

        /* Summary Item */
        .summary-item {
            display: flex;
            justify-content: space-between;
            align-items: baseline;
        }

        .summary-item span {
            font-size: 0.9rem;
        }

        .summary-item h6 {
            color: #10a37f;
            margin: 0;
            font-size: 1.25rem;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .card.sticky-top {
                position: static !important;
            }
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const uploadArea = document.getElementById('uploadArea');
            const buktiInput = document.getElementById('bukti_transfer');
            const fileInfo = document.getElementById('fileInfo');
            const fileName = document.getElementById('fileName');
            const fileSize = document.getElementById('fileSize');
            const submitBtn = document.getElementById('submitBtn');

            if (uploadArea && buktiInput) {
                uploadArea.addEventListener('click', () => buktiInput.click());

                uploadArea.addEventListener('dragover', (e) => {
                    e.preventDefault();
                    uploadArea.style.borderColor = '#059669';
                    uploadArea.style.background = 'rgba(16, 163, 127, 0.15)';
                });

                uploadArea.addEventListener('dragleave', () => {
                    uploadArea.style.borderColor = '#10a37f';
                    uploadArea.style.background = 'linear-gradient(135deg, rgba(16, 163, 127, 0.05) 0%, rgba(16, 163, 127, 0.02) 100%)';
                });

                uploadArea.addEventListener('drop', (e) => {
                    e.preventDefault();
                    uploadArea.style.borderColor = '#10a37f';
                    uploadArea.style.background = 'linear-gradient(135deg, rgba(16, 163, 127, 0.05) 0%, rgba(16, 163, 127, 0.02) 100%)';

                    const files = e.dataTransfer.files;
                    if (files.length > 0) {
                        buktiInput.files = files;
                        updateFileInfo();
                    }
                });

                buktiInput.addEventListener('change', updateFileInfo);
            }

            function updateFileInfo() {
                const file = buktiInput.files[0];
                if (file) {
                    fileName.textContent = file.name;
                    fileSize.textContent = (file.size / 1024).toFixed(2) + ' KB';
                    fileInfo.style.display = 'block';
                    submitBtn.style.display = 'block';
                }
            }
        });
    </script>
@endsection