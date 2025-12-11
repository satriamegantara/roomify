# Setup Guide - Kosan Hub

Panduan lengkap untuk setup dan menjalankan Kosan Hub di mesin lokal Anda.

## ✅ Checklist Persyaratan

-   [ ] PHP 8.2 atau lebih tinggi
-   [ ] Composer
-   [ ] Node.js 16+
-   [ ] MySQL 5.7+ atau SQLite
-   [ ] Git

## 📥 Step-by-Step Installation

### 1. Clone Repository

```bash
git clone <repository-url>
cd kosan
```

### 2. Install PHP Dependencies

```bash
composer install
```

### 3. Copy Environment File

```bash
cp .env.example .env
```

### 4. Generate Application Key

```bash
php artisan key:generate
```

### 5. Database Configuration

Edit file `.env` dan sesuaikan database connection:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=kosan_db
DB_USERNAME=root
DB_PASSWORD=
```

### 6. Create Database

```bash
mysql -u root -p
> CREATE DATABASE kosan_db;
> EXIT;
```

### 7. Run Migrations

```bash
php artisan migrate
```

### 8. Run Seeders (Optional - untuk data demo)

```bash
php artisan db:seed --class=KosanSeeder
```

### 9. Install JavaScript Dependencies

```bash
npm install
```

### 10. Build Assets

```bash
npm run dev
```

Untuk production:

```bash
npm run build
```

### 11. Start Development Server

Buka terminal baru dan jalankan:

```bash
php artisan serve
```

Aplikasi akan berjalan di: `http://localhost:8000`

## 🔑 Demo Credentials

Setelah menjalankan seeder, Anda bisa login dengan:

**Pemilik Kos:**

-   Email: `pemilik1@kosan.test`
-   Password: `password`

**Penyewa:**

-   Email: `penyewa1@kosan.test`
-   Password: `password`

## 🛠️ Troubleshooting

### Error: "No application encryption key has been generated"

```bash
php artisan key:generate
```

### Error: "SQLSTATE[HY000] [2002] Connection refused"

Pastikan MySQL service sudah berjalan dan konfigurasi .env benar.

### Error: "npm: command not found"

Install Node.js dari https://nodejs.org/

### Error: "Composer not found"

Install Composer dari https://getcomposer.org/

### Assets tidak ter-load saat development

Pastikan npm run dev sedang berjalan di terminal terpisah.

## 📂 Folder Penting

-   `app/` - Kode aplikasi (Models, Controllers, Policies)
-   `database/` - Migrations dan Seeders
-   `resources/` - Views dan CSS/JS
-   `routes/` - Route definitions
-   `public/` - Assets publik (CSS, JS, images)
-   `storage/` - Log files dan uploads

## 🔄 Development Workflow

### 1. Terminal 1 - Run Laravel Server

```bash
php artisan serve
```

### 2. Terminal 2 - Run Vite (Asset watcher)

```bash
npm run dev
```

### 3. Terminal 3 - Optional: Queue Listener

```bash
php artisan queue:listen
```

## 📝 Struktur File Penting

```
kosan/
├── .env                          # Konfigurasi environment
├── .env.example                  # Template .env
├── artisan                       # Laravel CLI
├── composer.json                 # PHP dependencies
├── package.json                  # Node.js dependencies
├── vite.config.js               # Vite configuration
├── phpunit.xml                  # Testing configuration
└── database/
    └── migrations/              # Database schema
```

## 🗄️ Database Migration Commands

```bash
# Run all pending migrations
php artisan migrate

# Rollback last migration
php artisan migrate:rollback

# Reset database (rollback all)
php artisan migrate:reset

# Refresh database (reset + migrate)
php artisan migrate:refresh

# Refresh + seed
php artisan migrate:refresh --seed
```

## 🧪 Testing

```bash
# Run all tests
php artisan test

# Run specific test
php artisan test tests/Feature/KosControllerTest.php

# Run with coverage
php artisan test --coverage
```

## 🚀 Deployment

### Untuk Production (Shared Hosting)

1. Upload files via FTP
2. Setup `.env` dengan production values
3. Run migrations: `php artisan migrate --force`
4. Build assets: `npm run build`
5. Set permissions:
    ```bash
    chmod -R 755 storage bootstrap/cache
    ```

### Untuk Production (VPS/Cloud)

1. Clone repository
2. Setup .env
3. Run composer: `composer install --no-dev`
4. Run npm: `npm install && npm run build`
5. Setup systemd service untuk Laravel
6. Configure nginx atau Apache
7. Setup SSL certificate

## 📚 Dokumentasi Lebih Lanjut

-   [Laravel Documentation](https://laravel.com/docs)
-   [Bootstrap Documentation](https://getbootstrap.com/docs)
-   [Vite Documentation](https://vitejs.dev/)
-   [Alpine.js Documentation](https://alpinejs.dev/)

## 🆘 Support

Jika mengalami masalah:

1. Cek error messages di `storage/logs/laravel.log`
2. Buat issue di repository dengan detail error
3. Sertakan output dari `php artisan about`

## ✨ Tips & Tricks

-   Gunakan `php artisan tinker` untuk experiment dengan code
-   Gunakan `php artisan serve --host=0.0.0.0` untuk akses dari device lain
-   Gunakan `npm run build` untuk production-optimized assets
-   Gunakan SQLite untuk development cepat (set `DB_CONNECTION=sqlite` di .env)

---

Happy coding! 🎉
