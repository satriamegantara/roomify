@extends('layouts.app')

@section('title', 'Detail Kos')

@section('content')
<div class="mb-4">
    <a href="{{ route('kos.index') }}" class="btn btn-outline-primary mb-3">
        <i class="bi bi-arrow-left me-2"></i>Kembali
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <!-- Gallery -->
        <div class="card border-0 shadow-sm mb-4">
            @if ($kos->foto_utama)
                <img src="{{ asset('storage/' . $kos->foto_utama) }}" class="card-img-top" alt="Foto Kos" style="height: 400px; object-fit: cover;">
            @else
                <img src="https://via.placeholder.com/800x400?text=Kos" class="card-img-top" alt="Foto Kos" style="height: 400px; object-fit: cover;">
            @endif
        </div>

        <!-- Foto Tambahan -->
        @if ($kos->foto_lainnya && count($kos->foto_lainnya) > 0)
            <div class="card border-0 shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="bi bi-images me-2"></i>Foto Lainnya</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        @foreach ($kos->foto_lainnya as $foto)
                            <div class="col-6 col-md-4">
                                <a href="{{ asset('storage/' . $foto) }}" data-lightbox="gallery" data-title="Foto Kos">
                                    <img src="{{ asset('storage/' . $foto) }}" class="img-fluid rounded shadow-sm" alt="Foto Kos" style="height: 150px; width: 100%; object-fit: cover; cursor: pointer;">
                                </a>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif

        <!-- Info Dasar -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-body">
                <h1 class="mb-3">{{ $kos->alamat }}</h1>
                
                <div class="row mb-4">
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Jenis Kos</p>
                        <p class="h5 text-primary">
                            @switch($kos->jenis_kos)
                                @case('putra')
                                    <i class="bi bi-person me-1"></i>Kos Putra
                                    @break
                                @case('putri')
                                    <i class="bi bi-person-fill me-1"></i>Kos Putri
                                    @break
                                @default
                                    <i class="bi bi-people me-1"></i>Kos Campur
                            @endswitch
                        </p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Harga per Bulan</p>
                        <p class="h5 text-success">Rp{{ number_format($kos->harga_bulanan, 0, ',', '.') }}</p>
                    </div>
                    <div class="col-md-4">
                        <p class="text-muted small mb-1">Rating</p>
                        <div>
                            @php
                                $rating = $kos->getAverageRating();
                                $ratingCount = $kos->ratingUlasans->count();
                            @endphp
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating)
                                    <i class="bi bi-star-fill text-warning"></i>
                                @else
                                    <i class="bi bi-star text-warning"></i>
                                @endif
                            @endfor
                            <span class="ms-2">{{ $rating }}/5 ({{ $ratingCount }} review)</span>
                        </div>
                    </div>
                </div>

                <span class="badge status-{{ $kos->status }} mb-3">{{ ucfirst($kos->status) }}</span>

                @auth
                    <div class="d-grid gap-2 mt-4">
                        <a href="{{ route('booking.create', $kos) }}" class="btn btn-primary btn-lg">
                            <i class="bi bi-calendar-check me-2"></i>Booking Sekarang
                        </a>
                        <a href="#chat" class="btn btn-outline-primary">
                            <i class="bi bi-chat-dots me-2"></i>Hubungi Pemilik
                        </a>
                    </div>
                @else
                    <div class="alert alert-info mt-4" role="alert">
                        <i class="bi bi-info-circle me-2"></i>
                        <a href="{{ route('login') }}">Login</a> untuk booking dan menghubungi pemilik
                    </div>
                @endauth
            </div>
        </div>

        <!-- Reviews -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <i class="bi bi-chat-left-quote me-2"></i>Review & Rating
            </div>
            <div class="card-body">
                @if ($kos->ratingUlasans->count() > 0)
                    @foreach ($kos->ratingUlasans as $review)
                        <div class="mb-4 pb-3 border-bottom">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <h6 class="mb-1">{{ $review->penyewa->name }}</h6>
                                    <div class="mb-2">
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $review->rating)
                                                <i class="bi bi-star-fill text-warning small"></i>
                                            @else
                                                <i class="bi bi-star text-warning small"></i>
                                            @endif
                                        @endfor
                                    </div>
                                </div>
                                <small class="text-muted">{{ $review->created_at->format('d M Y') }}</small>
                            </div>
                            @if ($review->ulasan)
                                <p class="text-muted mb-0">{{ $review->ulasan }}</p>
                            @endif
                        </div>
                    @endforeach
                @else
                    <p class="text-muted text-center py-4">Belum ada review</p>
                @endif

                @auth
                    <hr class="my-4">
                    <h6 class="mb-3">Tulis Review</h6>
                    <form action="{{ route('rating.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="kos_id" value="{{ $kos->id }}">
                        
                        <div class="mb-3">
                            <label class="form-label">Rating</label>
                            <div>
                                @for ($i = 1; $i <= 5; $i++)
                                    <input type="radio" name="rating" value="{{ $i }}" id="rating{{ $i }}" class="d-none" @checked(old('rating') == $i)>
                                    <label for="rating{{ $i }}" style="cursor: pointer; font-size: 1.5rem; color: #d1d5db; transition: color 0.2s;">
                                        <i class="bi bi-star-fill"></i>
                                    </label>
                                @endfor
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Ulasan</label>
                            <textarea name="ulasan" class="form-control" rows="4" placeholder="Bagikan pengalaman Anda..." maxlength="500">{{ old('ulasan') }}</textarea>
                        </div>

                        <button type="submit" class="btn btn-primary">
                            <i class="bi bi-send me-2"></i>Kirim Review
                        </button>
                    </form>
                @endauth
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="col-lg-4">
        <!-- Pemilik Info -->
        <div class="card border-0 shadow-sm mb-4">
            <div class="card-header">
                <i class="bi bi-person-check me-2"></i>Pemilik
            </div>
            <div class="card-body text-center">
                <div class="avatar mb-3" style="width: 80px; height: 80px; background: linear-gradient(135deg, #10a37f, #059669); border-radius: 50%; margin: 0 auto; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                    <i class="bi bi-person-fill"></i>
                </div>
                <h5>{{ $kos->pemilik->name }}</h5>
                <p class="text-muted small mb-3">{{ $kos->pemilik->email }}</p>
                @auth
                    <a href="#" class="btn btn-sm btn-outline-primary w-100">
                        <i class="bi bi-chat-dots me-2"></i>Hubungi
                    </a>
                @endauth
            </div>
        </div>

        <!-- Quick Info -->
        <div class="card border-0 shadow-sm">
            <div class="card-header">
                <i class="bi bi-info-circle me-2"></i>Informasi
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <p class="text-muted small mb-1">Total Booking</p>
                    <p class="h6">{{ $kos->bookings->count() }} Penyewa</p>
                </div>
                <div class="mb-3">
                    <p class="text-muted small mb-1">Status</p>
                    <p class="h6">
                        <span class="badge status-{{ $kos->status }}">{{ ucfirst($kos->status) }}</span>
                    </p>
                </div>
                <div>
                    <p class="text-muted small mb-1">Verifikasi</p>
                    <p class="h6">
                        @if ($kos->verified_at)
                            <i class="bi bi-check-circle text-success me-2"></i>Terverifikasi
                        @else
                            <i class="bi bi-exclamation-circle text-warning me-2"></i>Belum Verifikasi
                        @endif
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Rating star interaction
    const ratingInputs = document.querySelectorAll('input[name="rating"]');
    const ratingLabels = document.querySelectorAll('label[for^="rating"]');

    ratingLabels.forEach(label => {
        label.addEventListener('mouseover', function() {
            const index = this.getAttribute('for').replace('rating', '');
            ratingLabels.forEach((l, i) => {
                l.style.color = i < index ? '#f59e0b' : '#d1d5db';
            });
        });
    });

    document.addEventListener('mouseleave', function() {
        const checked = document.querySelector('input[name="rating"]:checked');
        if (checked) {
            const index = checked.value;
            ratingLabels.forEach((l, i) => {
                l.style.color = i < index ? '#f59e0b' : '#d1d5db';
            });
        } else {
            ratingLabels.forEach(l => {
                l.style.color = '#d1d5db';
            });
        }
    });

    ratingInputs.forEach(input => {
        input.addEventListener('change', function() {
            const index = this.value;
            ratingLabels.forEach((l, i) => {
                l.style.color = i < index ? '#f59e0b' : '#d1d5db';
            });
        });
    });

    // Lightbox for gallery images
    const galleryImages = document.querySelectorAll('[data-lightbox="gallery"]');
    
    if (galleryImages.length > 0) {
        // Create lightbox modal
        const lightboxModal = document.createElement('div');
        lightboxModal.id = 'lightboxModal';
        lightboxModal.style.cssText = 'display:none;position:fixed;z-index:9999;left:0;top:0;width:100%;height:100%;background-color:rgba(0,0,0,0.9);';
        
        const lightboxContent = document.createElement('div');
        lightboxContent.style.cssText = 'position:relative;margin:auto;top:50%;transform:translateY(-50%);text-align:center;max-width:90%;max-height:90vh;';
        
        const lightboxImg = document.createElement('img');
        lightboxImg.id = 'lightboxImg';
        lightboxImg.style.cssText = 'max-width:100%;max-height:90vh;box-shadow:0 4px 6px rgba(0,0,0,0.3);';
        
        const lightboxClose = document.createElement('span');
        lightboxClose.innerHTML = '&times;';
        lightboxClose.style.cssText = 'position:absolute;top:-40px;right:0;color:#fff;font-size:40px;font-weight:bold;cursor:pointer;';
        lightboxClose.onclick = function() {
            lightboxModal.style.display = 'none';
        };
        
        lightboxContent.appendChild(lightboxClose);
        lightboxContent.appendChild(lightboxImg);
        lightboxModal.appendChild(lightboxContent);
        document.body.appendChild(lightboxModal);
        
        // Add click event to gallery images
        galleryImages.forEach(img => {
            img.addEventListener('click', function(e) {
                e.preventDefault();
                lightboxImg.src = this.href;
                lightboxModal.style.display = 'block';
            });
        });
        
        // Close on click outside
        lightboxModal.addEventListener('click', function(e) {
            if (e.target === lightboxModal) {
                lightboxModal.style.display = 'none';
            }
        });
        
        // Close on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                lightboxModal.style.display = 'none';
            }
        });
    }
</script>
@endpush
@endsection
