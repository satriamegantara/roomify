<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    /** @use HasFactory<\Database\Factories\PembayaranFactory> */
    use HasFactory;

    protected $table = 'pembayaran';

    protected $fillable = [
        'penyewa_id',
        'kos_id',
        'jumlah',
        'metode',
        'status',
        'bukti_transfer',
        'bulan_tahun',
    ];

    protected $casts = [
        'bulan_tahun' => 'date',
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
