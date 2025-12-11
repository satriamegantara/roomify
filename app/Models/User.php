<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function kosAsOwner(): HasMany
    {
        return $this->hasMany(Kos::class, 'pemilik_id');
    }

    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class, 'penyewa_id');
    }

    public function pembayarans(): HasMany
    {
        return $this->hasMany(Pembayaran::class, 'penyewa_id');
    }

    public function ratingUlasans(): HasMany
    {
        return $this->hasMany(RatingUlasan::class, 'penyewa_id');
    }

    public function chatsAsSender(): HasMany
    {
        return $this->hasMany(Chat::class, 'sender_id');
    }

    public function chatsAsReceiver(): HasMany
    {
        return $this->hasMany(Chat::class, 'receiver_id');
    }
}
