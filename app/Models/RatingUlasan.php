<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RatingUlasan extends Model
{
    /** @use HasFactory<\Database\Factories\RatingUlasanFactory> */
    use HasFactory;

    protected $table = 'rating_ulasan';

    protected $fillable = [
        'penyewa_id',
        'kos_id',
        'rating',
        'ulasan',
    ];

    public function penyewa(): BelongsTo
    {
        return $this->belongsTo(User::class, 'penyewa_id');
    }

    public function kos(): BelongsTo
    {
        return $this->belongsTo(Kos::class);
    }
}
