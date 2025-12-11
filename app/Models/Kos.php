<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Kos extends Model
{
    /** @use HasFactory<\Database\Factories\KosFactory> */
    use HasFactory;

    protected $table = 'kos';

    protected $fillable = [
        'pemilik_id',
        'alamat',
        'harga_bulanan',
        'jenis_kos',
        'status',
        'rating_rata_rata',
        'foto_utama',
        'foto_lainnya',
        'verified_at',
    ];

    protected $casts = [
        'foto_lainnya' => 'array',
        'verified_at' => 'datetime',
    ];

    public function pemilik(): BelongsTo
    {
        return $this->belongsTo(User::class, 'pemilik_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class);
    }

    public function ratingUlasans(): HasMany
    {
        return $this->hasMany(RatingUlasan::class);
    }

    public function isActive(): bool
    {
        return $this->status === 'aktif';
    }

    public function getAverageRating(): float
    {
        return round($this->ratingUlasans()->avg('rating') ?? 0, 2);
    }
}
