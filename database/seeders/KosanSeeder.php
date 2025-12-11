<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Kos;
use App\Models\Booking;
use App\Models\RatingUlasan;
use Illuminate\Database\Seeder;

class KosanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create owner users
        $owner1 = User::firstOrCreate(
            ['email' => 'pemilik1@kosan.test'],
            [
                'name' => 'Budi Santoso',
                'password' => bcrypt('password'),
                'role' => 'pemilik',
            ]
        );

        $owner2 = User::firstOrCreate(
            ['email' => 'pemilik2@kosan.test'],
            [
                'name' => 'Siti Nurhaliza',
                'password' => bcrypt('password'),
                'role' => 'pemilik',
            ]
        );

        // Create tenant users
        $tenant1 = User::firstOrCreate(
            ['email' => 'penyewa1@kosan.test'],
            [
                'name' => 'Ahmad Hidayat',
                'password' => bcrypt('password'),
                'role' => 'penyewa',
            ]
        );

        $tenant2 = User::firstOrCreate(
            ['email' => 'penyewa2@kosan.test'],
            [
                'name' => 'Dewi Anggraini',
                'password' => bcrypt('password'),
                'role' => 'penyewa',
            ]
        );

        // Create kos listings
        $kos1 = Kos::create([
            'pemilik_id' => $owner1->id,
            'alamat' => 'Jl. Merdeka No. 42, Jakarta Pusat',
            'harga_bulanan' => 2000000,
            'jenis_kos' => 'putra',
            'status' => 'aktif',
            'rating_rata_rata' => 4.5,
            'foto_utama' => 'https://via.placeholder.com/400x300?text=Kos+Putra+Jakarta',
            'verified_at' => now(),
        ]);

        $kos2 = Kos::create([
            'pemilik_id' => $owner1->id,
            'alamat' => 'Jl. Ahmad Yani No. 15, Bandung',
            'harga_bulanan' => 1500000,
            'jenis_kos' => 'putri',
            'status' => 'aktif',
            'rating_rata_rata' => 4.8,
            'foto_utama' => 'https://via.placeholder.com/400x300?text=Kos+Putri+Bandung',
            'verified_at' => now(),
        ]);

        $kos3 = Kos::create([
            'pemilik_id' => $owner2->id,
            'alamat' => 'Jl. Diponegoro No. 8, Yogyakarta',
            'harga_bulanan' => 1200000,
            'jenis_kos' => 'campur',
            'status' => 'aktif',
            'rating_rata_rata' => 4.2,
            'foto_utama' => 'https://via.placeholder.com/400x300?text=Kos+Campur+Yogyakarta',
            'verified_at' => now(),
        ]);

        $kos4 = Kos::create([
            'pemilik_id' => $owner2->id,
            'alamat' => 'Jl. Sudirman No. 50, Surabaya',
            'harga_bulanan' => 1800000,
            'jenis_kos' => 'putra',
            'status' => 'penuh',
            'rating_rata_rata' => 4.6,
            'foto_utama' => 'https://via.placeholder.com/400x300?text=Kos+Surabaya',
            'verified_at' => now(),
        ]);

        // Create bookings
        Booking::create([
            'penyewa_id' => $tenant1->id,
            'kos_id' => $kos1->id,
            'tanggal_kunjungan' => now()->addDay(),
            'status' => 'pending',
        ]);

        Booking::create([
            'penyewa_id' => $tenant2->id,
            'kos_id' => $kos2->id,
            'tanggal_kunjungan' => now()->addDays(2),
            'status' => 'aktif',
        ]);

        // Create ratings
        RatingUlasan::create([
            'penyewa_id' => $tenant2->id,
            'kos_id' => $kos2->id,
            'rating' => 5,
            'ulasan' => 'Kos yang sangat nyaman dan bersih, pemilik juga sangat ramah!',
        ]);

        RatingUlasan::create([
            'penyewa_id' => $tenant1->id,
            'kos_id' => $kos1->id,
            'rating' => 4,
            'ulasan' => 'Lokasi strategis, dekat dengan berbagai fasilitas umum.',
        ]);
    }
}
