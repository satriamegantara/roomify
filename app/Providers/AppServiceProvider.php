<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Models\Booking;
use App\Policies\BookingPolicy;
use App\Models\Pembayaran;
use App\Policies\PembayaranPolicy;
use App\Models\Chat;
use App\Policies\ChatPolicy;

class AppServiceProvider extends ServiceProvider
{
    protected $policies = [
        Booking::class => BookingPolicy::class,
        Pembayaran::class => PembayaranPolicy::class,
        Chat::class => ChatPolicy::class,
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
