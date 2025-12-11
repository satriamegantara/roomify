# Kosan Hub - Sistem Informasi Kos-Kosan

Platform web modern untuk membantu pencari kos menemukan hunian yang tepat dan pemilik kos mengelola properti mereka dengan efisien.

## 🎨 Fitur Utama

-   **Pencarian Kos Dinamis**: Filter berdasarkan lokasi, jenis kos (putra/putri/campur), dan harga
-   **Detail Kos Lengkap**: Informasi lengkap tentang setiap kos dengan foto dan pemilik
-   **Sistem Rating & Review**: Penyewa dapat memberikan rating dan ulasan tentang kos
-   **Booking System**: Fitur untuk membuat janji kunjungan dengan pemilik
-   **Chat Langsung**: Komunikasi real-time antara penyewa dan pemilik
-   **Manajemen Pembayaran**: Sistem pembayaran dengan bukti transfer
-   **Dashboard**: Panel kontrol untuk pemilik dan penyewa
-   **Responsive Design**: Desain yang optimal di semua ukuran perangkat

## 🎯 Teknologi

-   **Backend**: Laravel 12 (PHP)
-   **Frontend**: Bootstrap 5 + Alpine.js
-   **Database**: MySQL/SQLite
-   **Build Tool**: Vite
-   **Authentication**: Laravel Breeze

## 🌈 Warna Tema

-   **Primary Green**: `#10a37f` (Hijau Utama)
-   **Secondary Green**: `#34d399` (Hijau Muda)
-   **Dark Green**: `#059669` (Hijau Gelap)
-   **Secondary**: `#f3f4f6` (Abu-abu Muda)
-   **White**: `#ffffff`

## 📊 Struktur Database

### Users

-   id (bigint)
-   name (string)
-   email (string, unique)
-   password (string)
-   role (enum: penyewa/pemilik/admin)
-   email_verified_at (timestamp nullable)
-   created_at, updated_at

### Kos

-   id (bigint)
-   pemilik_id (foreign key ke users)
-   alamat (text)
-   harga_bulanan (decimal)
-   jenis_kos (enum: putra/putri/campur)
-   status (enum: aktif/tidak_aktif/penuh)
-   rating_rata_rata (decimal)
-   foto_utama (string)
-   foto_lainnya (json)
-   verified_at (timestamp nullable)
-   created_at, updated_at

### Bookings

-   id (bigint)
-   penyewa_id (foreign key ke users)
-   kos_id (foreign key ke kos)
-   tanggal_kunjungan (date)
-   status (enum: pending/aktif/selesai/dibatalkan)
-   created_at, updated_at

### Pembayarans

-   id (bigint)
-   penyewa_id (foreign key ke users)
-   kos_id (foreign key ke kos)
-   jumlah (decimal)
-   metode (enum: transfer/tunai/e_wallet)
-   status (enum: pending/lunas/terlambat)
-   bukti_transfer (string)
-   bulan_tahun (date)
-   created_at, updated_at

### Ratings_Ulasans

-   id (bigint)
-   penyewa_id (foreign key ke users)
-   kos_id (foreign key ke kos)
-   rating (integer 1-5)
-   ulasan (text)
-   created_at, updated_at

### Chats

-   id (bigint)
-   sender_id (foreign key ke users)
-   receiver_id (foreign key ke users)
-   message (text)
-   is_read (boolean)
-   created_at, updated_at

### Notifications

-   id (bigint)
-   user_id (foreign key ke users)
-   type (string)
-   data (json)
-   read_at (timestamp nullable)
-   created_at, updated_at

## 🚀 Instalasi & Setup

### Persyaratan

-   PHP 8.2+
-   Composer
-   Node.js 16+
-   MySQL/SQLite

### Langkah Instalasi

1. **Clone Repository**

```bash
git clone <repository-url>
cd kosan
```

2. **Install Dependencies**

```bash
composer install
npm install
```

3. **Setup Environment**

```bash
cp .env.example .env
php artisan key:generate
```

4. **Database Setup**

```bash
php artisan migrate
php artisan db:seed --class=KosanSeeder
```

5. **Build Assets**

```bash
npm run build
```

6. **Jalankan Development Server**

```bash
php artisan serve
npm run dev
```

## 📝 Akun Demo

Setelah menjalankan seeder, Anda dapat login dengan:

### Pemilik Kos

-   Email: `pemilik1@kosan.test`
-   Password: `password`

### Penyewa

-   Email: `penyewa1@kosan.test`
-   Password: `password`

## 🗂️ Struktur Folder

```
kosan/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── KosController.php
│   │   │   ├── BookingController.php
│   │   │   ├── RatingController.php
│   │   │   ├── PembayaranController.php
│   │   │   ├── ChatController.php
│   │   │   └── DashboardController.php
│   │   └── Requests/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Kos.php
│   │   ├── Booking.php
│   │   ├── RatingUlasan.php
│   │   ├── Pembayaran.php
│   │   ├── Chat.php
│   │   └── Notification.php
│   └── Policies/
│       ├── BookingPolicy.php
│       ├── PembayaranPolicy.php
│       └── ChatPolicy.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   │   └── KosanSeeder.php
│   └── factories/
├── resources/
│   ├── views/
│   │   ├── layouts/
│   │   │   └── app.blade.php
│   │   ├── kos/
│   │   │   ├── index.blade.php
│   │   │   └── show.blade.php
│   │   ├── booking/
│   │   │   ├── index.blade.php
│   │   │   ├── create.blade.php
│   │   │   └── show.blade.php
│   │   ├── pembayaran/
│   │   ├── chat/
│   │   ├── dashboard.blade.php
│   │   ├── welcome.blade.php
│   │   └── auth/
│   ├── css/
│   │   ├── app.css
│   │   └── kosan-theme.css
│   └── js/
│       ├── app.js
│       └── bootstrap.js
└── routes/
    ├── web.php
    ├── auth.php
    └── console.php
```

## 📋 Route Mapping

### Public Routes

-   `GET /` - Homepage
-   `GET /kos` - List semua kos
-   `GET /kos/{kos}` - Detail kos
-   `GET /kos/search` - Search kos
-   `GET /login` - Login page
-   `GET /register` - Register page

### Authenticated Routes

-   `GET /dashboard` - Dashboard
-   `GET /booking` - List booking saya
-   `GET /booking/create/{kos}` - Create booking
-   `POST /booking/{kos}` - Store booking
-   `GET /booking/{booking}` - Detail booking
-   `PUT /booking/{booking}/cancel` - Cancel booking
-   `POST /rating` - Store rating
-   `GET /pembayaran` - List pembayaran
-   `GET /pembayaran/{pembayaran}` - Detail pembayaran
-   `POST /pembayaran/{pembayaran}/bukti` - Upload bukti

## 🔐 Authorization

Sistem menggunakan Laravel Policies untuk kontrol akses:

-   **BookingPolicy**: Hanya penyewa dan pemilik yang bisa melihat booking mereka
-   **PembayaranPolicy**: Hanya penyewa dan pemilik yang bisa melihat pembayaran
-   **ChatPolicy**: Hanya peserta chat yang bisa melihat pesan

## 🎨 Customization

### Mengubah Warna Tema

Edit `resources/css/kosan-theme.css`:

```css
:root {
    --kosan-primary: #10a37f; /* Warna hijau utama */
    --kosan-primary-light: #34d399;
    --kosan-primary-dark: #059669;
    --kosan-secondary: #f3f4f6;
    --kosan-white: #ffffff;
}
```

## 🐛 Testing

### Run Tests

```bash
php artisan test
```

### Run Specific Test

```bash
php artisan test tests/Feature/KosControllerTest.php
```

## 📦 Build untuk Production

```bash
npm run build
php artisan optimize
php artisan config:cache
```

## 🤝 Kontribusi

1. Fork repository
2. Buat branch fitur (`git checkout -b feature/AmazingFeature`)
3. Commit changes (`git commit -m 'Add some AmazingFeature'`)
4. Push ke branch (`git push origin feature/AmazingFeature`)
5. Buat Pull Request

## 📄 Lisensi

MIT License - Lihat file LICENSE untuk detail.

## 📞 Support

Untuk pertanyaan atau masalah, silakan buat issue di repository.

---

**Kosan Hub** - Platform Informasi Kos-Kosan Terpercaya | 2025
