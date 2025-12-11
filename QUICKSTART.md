# Quick Start - Kosan Hub

Mulai dengan Kosan Hub dalam 5 menit!

## 🚀 Instalasi Cepat (5 Menit)

### Step 1: Install Dependencies

```bash
composer install
npm install
```

### Step 2: Setup Environment

```bash
cp .env.example .env
php artisan key:generate
```

### Step 3: Setup Database

```bash
# Buat database kosong terlebih dahulu
# Kemudian run migrations
php artisan migrate:refresh --seed
```

### Step 4: Build Assets

```bash
npm run build
```

### Step 5: Run Server

Terminal 1:

```bash
php artisan serve
```

Terminal 2:

```bash
npm run dev
```

✨ **Done!** Akses di `http://localhost:8000`

---

## 📝 Login Demo Accounts

| Role    | Email               | Password |
| ------- | ------------------- | -------- |
| Pemilik | pemilik1@kosan.test | password |
| Penyewa | penyewa1@kosan.test | password |

---

## 🎯 Quick Features Overview

### 📍 Untuk Penyewa

1. **Cari Kos** - Browse listing dengan filter lokasi & harga
2. **Lihat Detail** - Info lengkap, rating, review, pemilik
3. **Booking** - Jadwalkan kunjungan
4. **Rating** - Beri review & rating

### 🏠 Untuk Pemilik

1. **Dashboard** - Lihat statistik kos & booking
2. **Manage Kos** - List kos yang dimiliki
3. **Accept Booking** - Terima/tolak booking
4. **Chat** - Komunikasi dengan penyewa

---

## 🛠️ Common Commands

```bash
# Database
php artisan migrate                 # Run migrations
php artisan migrate:refresh         # Reset & migrate
php artisan migrate:refresh --seed  # Reset & seed data
php artisan db:seed                 # Run seeders

# Development
php artisan serve                   # Start server (port 8000)
php artisan serve --port=3000       # Custom port
php artisan tinker                  # Interactive shell

# Assets
npm run dev                          # Development (watch mode)
npm run build                        # Production build

# Cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

---

## 📁 File Structure

```
kosan/
├── app/
│   ├── Models/              # Database models
│   ├── Controllers/         # Request handlers
│   └── Policies/            # Authorization
├── database/
│   └── migrations/          # Schema changes
├── resources/
│   ├── views/              # Blade templates
│   ├── css/                # Stylesheets
│   └── js/                 # JavaScript
├── routes/
│   └── web.php             # Route definitions
├── .env                    # Configuration
├── vite.config.js          # Build config
└── composer.json           # PHP packages
```

---

## 🎨 Customization

### Change Primary Color

Edit `resources/css/kosan-theme.css`:

```css
:root {
    --kosan-primary: #10a37f; /* Change this */
    --kosan-primary-light: #34d399;
    --kosan-primary-dark: #059669;
}
```

### Change App Name

1. Edit `.env` - `APP_NAME=Kosan Hub`
2. Update `resources/views/layouts/app.blade.php` navbar

### Change Database

Edit `.env`:

```env
DB_CONNECTION=mysql  # or sqlite, pgsql, etc
DB_DATABASE=kosan_db
```

---

## ✅ Testing Checklist

-   [ ] Homepage loads
-   [ ] Can browse kos listings
-   [ ] Can search & filter kos
-   [ ] Can view kos detail
-   [ ] Can login/register
-   [ ] Can create booking (logged in)
-   [ ] Can add rating/review
-   [ ] Dashboard shows stats
-   [ ] Mobile responsive (open in mobile browser)

---

## 🆘 Quick Troubleshooting

**Issue: "No application encryption key"**

```bash
php artisan key:generate
```

**Issue: "Database connection error"**

-   Check MySQL is running
-   Verify .env DB\_\* values
-   Ensure database exists

**Issue: "Assets not loading"**

-   Run `npm run build`
-   Check assets are in public/build/
-   Clear browser cache (Ctrl+Shift+Delete)

**Issue: "Port 8000 already in use"**

```bash
php artisan serve --port=8001
```

---

## 📚 Learn More

-   [Full Documentation](./DOKUMENTASI.md)
-   [Setup Guide](./SETUP_GUIDE.md)
-   [Laravel Docs](https://laravel.com/docs)
-   [Bootstrap Docs](https://getbootstrap.com/docs)

---

## 🎉 Next Steps

1. ✅ Setup & run project
2. ✅ Login dengan demo accounts
3. ✅ Explore features
4. ✅ Customize untuk kebutuhan Anda
5. ✅ Deploy ke production

**Happy coding!** 🚀
