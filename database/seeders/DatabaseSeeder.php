<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User (if not exists)
        User::firstOrCreate(
            ['email' => 'admin@roomify.test'],
            [
                'name' => 'Admin Roomify',
                'password' => bcrypt('admin123456'),
                'role' => 'admin',
            ]
        );

        // Create Test User (Penyewa) (if not exists)
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            [
                'name' => 'Test User',
                'password' => bcrypt('password'),
                'role' => 'penyewa',
            ]
        );

        // Create Test Pemilik (if not exists)
        User::firstOrCreate(
            ['email' => 'pemilik@example.com'],
            [
                'name' => 'Test Pemilik',
                'password' => bcrypt('password'),
                'role' => 'pemilik',
            ]
        );
    }
}
