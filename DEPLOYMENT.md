# DEPLOYMENT GUIDE - Kosan Hub

Panduan lengkap untuk mendeploy Kosan Hub ke production environment.

## 🚀 Pre-Deployment Checklist

-   [ ] Test semua fitur di local
-   [ ] Run `php artisan test`
-   [ ] Clear cache: `php artisan optimize:clear`
-   [ ] Update .env untuk production
-   [ ] Setup SSL certificate
-   [ ] Backup database
-   [ ] Test payment gateway (jika ada)
-   [ ] Test email notifications
-   [ ] Update database credentials
-   [ ] Set secure file permissions

---

## 📋 Opsi Deployment

### Option 1: Shared Hosting (cPanel)

#### A. Upload Files via FTP

1. ZIP project `composer install --no-dev && npm run build` locally
2. Extract di hosting
3. Update `.env` dengan production values

#### B. Database Setup

1. Create database di cPanel
2. Create user & assign permissions
3. Update DB\_\* di `.env`
4. Run migrations: `php artisan migrate --force`

#### C. Document Root

```
Pointer public/index.php ke domain Anda di File Manager
```

#### D. Permissions

```bash
chmod 755 storage bootstrap/cache
chmod 644 .env
```

#### E. PHP Configuration

-   Ensure PHP 8.2+
-   Enable: mbstring, openssl, json, ctype, tokenizer
-   Set memory_limit ≥ 256M

### Option 2: VPS/Cloud Server (DigitalOcean, Linode, AWS)

#### A. Initial Setup

```bash
# SSH ke server
ssh root@your_server_ip

# Update system
apt update && apt upgrade -y

# Install dependencies
apt install -y php8.2-fpm php8.2-mysql php8.2-mbstring \
  php8.2-json php8.2-curl php8.2-gd php8.2-zip nginx \
  mysql-server composer git curl

# Enable PHP modules
phpenmod mbstring json ctype tokenizer bcmath
```

#### B. Setup Application User

```bash
adduser --disabled-password --gecos '' appuser
usermod -aG www-data appuser
```

#### C. Clone & Setup Repository

```bash
cd /var/www
git clone <repository-url> kosan
cd kosan
chown -R appuser:www-data .
chmod -R 775 storage bootstrap/cache

# Install dependencies
composer install --no-dev --optimize-autoloader
npm install && npm run build

# Setup .env
cp .env.example .env
php artisan key:generate
# Edit .env dengan production values
```

#### D. Database Setup

```bash
# Login ke MySQL
mysql -u root -p

# Create database & user
CREATE DATABASE kosan_db;
CREATE USER 'kosan_user'@'localhost' IDENTIFIED BY 'strong_password';
GRANT ALL PRIVILEGES ON kosan_db.* TO 'kosan_user'@'localhost';
FLUSH PRIVILEGES;
EXIT;

# Update .env dengan credentials
# Run migrations
php artisan migrate --force
```

#### E. Nginx Configuration

Create `/etc/nginx/sites-available/kosan`:

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your_domain.com www.your_domain.com;

    root /var/www/kosan/public;
    index index.php index.html;

    # SSL redirect (jika sudah ada certificate)
    # return 301 https://$server_name$request_uri;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/run/php/php8.2-fpm.sock;
        fastcgi_index index.php;
        include fastcgi_params;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
    }

    location ~ /\.env {
        deny all;
    }

    location ~ /\.ht {
        deny all;
    }

    client_max_body_size 100M;
}
```

Enable site:

```bash
ln -s /etc/nginx/sites-available/kosan /etc/nginx/sites-enabled/
rm /etc/nginx/sites-enabled/default
nginx -t
systemctl restart nginx
```

#### F. SSL Certificate (Let's Encrypt)

```bash
apt install -y certbot python3-certbot-nginx
certbot certonly --nginx -d your_domain.com -d www.your_domain.com

# Update nginx config to use SSL
# Edit /etc/nginx/sites-available/kosan dan add SSL config
```

SSL Nginx Config:

```nginx
listen 443 ssl http2;
listen [::]:443 ssl http2;

ssl_certificate /etc/letsencrypt/live/your_domain.com/fullchain.pem;
ssl_certificate_key /etc/letsencrypt/live/your_domain.com/privkey.pem;
ssl_protocols TLSv1.2 TLSv1.3;
ssl_ciphers HIGH:!aNULL:!MD5;
ssl_prefer_server_ciphers on;
```

#### G. Systemd Service (Optional, untuk daemon)

Create `/etc/systemd/system/kosan-queue.service`:

```ini
[Unit]
Description=Kosan Queue Service
After=network.target

[Service]
Type=simple
User=appuser
WorkingDirectory=/var/www/kosan
ExecStart=/usr/bin/php artisan queue:listen
Restart=always
RestartSec=10

[Install]
WantedBy=multi-user.target
```

Enable & start:

```bash
systemctl enable kosan-queue
systemctl start kosan-queue
```

### Option 3: Heroku Deployment

#### A. Setup Heroku

```bash
# Install Heroku CLI
# Login
heroku login

# Create app
heroku create your-app-name
heroku buildpacks:add heroku/php
heroku buildpacks:add heroku/nodejs
```

#### B. Procfile

Create `Procfile`:

```
web: vendor/bin/heroku-php-apache2 public/
queue: php artisan queue:listen
```

#### C. Deploy

```bash
git push heroku main

# Setup database
heroku addons:create cleardb:ignite
heroku run php artisan migrate
heroku run php artisan db:seed --class=KosanSeeder
```

### Option 4: Docker Deployment

#### A. Dockerfile

```dockerfile
FROM php:8.2-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
    mysql-client \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    unzip

RUN docker-php-ext-install pdo_mysql gd

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

COPY . .

RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

RUN chown -R www-data:www-data storage bootstrap/cache

EXPOSE 8000

CMD ["php-fpm"]
```

#### B. docker-compose.yml

```yaml
version: "3.8"

services:
    app:
        build: .
        ports:
            - "8000:8000"
        environment:
            DB_HOST: db
            DB_USER: kosan_user
            DB_PASSWORD: password
            DB_NAME: kosan_db
        volumes:
            - .:/var/www/html
        depends_on:
            - db

    db:
        image: mysql:8.0
        environment:
            MYSQL_ROOT_PASSWORD: root
            MYSQL_DATABASE: kosan_db
            MYSQL_USER: kosan_user
            MYSQL_PASSWORD: password
        volumes:
            - dbdata:/var/lib/mysql

volumes:
    dbdata:
```

Deploy:

```bash
docker-compose up -d
docker-compose exec app php artisan migrate
docker-compose exec app php artisan db:seed
```

---

## 🔧 Post-Deployment Configuration

### 1. Environment Variables

```bash
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your_domain.com
DB_HOST=localhost
DB_DATABASE=kosan_db
DB_USERNAME=kosan_user
DB_PASSWORD=your_strong_password
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
```

### 2. Caching & Optimization

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan optimize
```

### 3. Cronjob Setup

```bash
# Add to crontab
* * * * * cd /var/www/kosan && php artisan schedule:run >> /dev/null 2>&1
```

### 4. Storage Link (untuk file uploads)

```bash
php artisan storage:link
```

### 5. Log Rotation

```bash
# Ensure logs are rotated
logrotate -d /var/log/kosan.log
```

---

## 📊 Performance Optimization

### 1. Database Optimization

```bash
php artisan migrate --force
# Add indexes untuk frequently queried columns
```

### 2. Asset Minification

```bash
npm run build  # Already minified
```

### 3. Caching Headers

Edit `.htaccess` atau nginx config:

```
ExpiresByType image/* "access plus 1 year"
ExpiresByType application/javascript "access plus 1 month"
ExpiresByType text/css "access plus 1 month"
```

### 4. Query Optimization

-   Use eager loading (with())
-   Add database indexes
-   Use pagination untuk large datasets

### 5. CDN Setup (Optional)

```env
CDN_URL=https://cdn.your_domain.com
```

---

## 🔒 Security Hardening

### 1. HTTPS/SSL

-   ✅ Install SSL certificate
-   ✅ Redirect HTTP to HTTPS
-   ✅ Set HSTS header

### 2. Security Headers

Add ke .env atau nginx:

```
X-Content-Type-Options: nosniff
X-Frame-Options: SAMEORIGIN
X-XSS-Protection: 1; mode=block
Strict-Transport-Security: max-age=31536000
```

### 3. File Permissions

```bash
chmod 755 bootstrap/cache storage
chmod 644 .env
chmod 644 bootstrap/app.php
```

### 4. Database Security

-   ✅ Use strong passwords
-   ✅ Restrict database user privileges
-   ✅ Regular backups
-   ✅ Enable binary logging

### 5. Firewall & SSH

```bash
# Setup UFW
ufw allow 22/tcp
ufw allow 80/tcp
ufw allow 443/tcp
ufw enable

# SSH key only (no password)
PermitRootLogin no
PasswordAuthentication no
```

---

## 📈 Monitoring & Logging

### 1. Application Logs

```bash
tail -f storage/logs/laravel.log
```

### 2. Nginx Logs

```bash
tail -f /var/log/nginx/error.log
tail -f /var/log/nginx/access.log
```

### 3. Application Monitoring

-   Setup New Relic / DataDog
-   Configure error reporting (Sentry)
-   Setup uptime monitoring

### 4. Database Monitoring

-   Monitor slow queries
-   Check table sizes
-   Optimize indexes

---

## 🔄 Backup Strategy

### 1. Database Backup

```bash
# Daily backup script
mysqldump -u kosan_user -p kosan_db > /backups/kosan_$(date +%Y%m%d).sql

# Or with automation
0 2 * * * mysqldump -u kosan_user -p kosan_db > /backups/kosan_$(date +\%Y\%m\%d).sql
```

### 2. File Backup

```bash
tar -czf /backups/kosan_files_$(date +%Y%m%d).tar.gz /var/www/kosan
```

### 3. Off-site Backup

-   Setup AWS S3 backup
-   Or Google Cloud Storage
-   Or Dropbox integration

---

## 🚨 Troubleshooting

### Issue: 500 Error

```bash
# Check logs
tail -50 storage/logs/laravel.log

# Verify permissions
chmod -R 755 storage bootstrap/cache

# Clear cache
php artisan optimize:clear
```

### Issue: Database Connection Error

```bash
# Check connection
php artisan tinker
DB::connection()->getPdo();

# Verify credentials in .env
```

### Issue: Email Not Sending

```bash
# Check mail config
php artisan config:clear

# Test mailing
php artisan tinker
Mail::raw('Test', fn($m) => $m->to('test@example.com'));
```

### Issue: Assets 404

```bash
# Rebuild assets
npm run build

# Check public/build directory exists
ls -la public/build/
```

---

## 📝 Maintenance

### Daily

-   Monitor error logs
-   Check disk space
-   Verify backups

### Weekly

-   Review user activity
-   Check database performance
-   Test restore from backup

### Monthly

-   Update dependencies
-   Review security logs
-   Performance analysis

---

## 🎉 Deployment Complete!

Setelah mengikuti panduan ini, Kosan Hub seharusnya sudah berjalan di production dengan aman dan optimal.

---

**Last Updated:** 2025-01-02
**Status:** Ready for Production
