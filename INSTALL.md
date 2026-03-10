# Panduan Instalasi Sistem Cuti Pegawai Online

## Persyaratan Sistem

### Minimum Requirements
- **PHP**: Versi 8.1 atau lebih tinggi
- **Database**: MySQL 5.7+ atau MariaDB 10.3+
- **Web Server**: Apache/Nginx
- **Composer**: Versi 2.0 atau lebih tinggi
- **XAMPP**: Versi 8.1 atau lebih tinggi (untuk Windows)

### PHP Extensions yang Diperlukan
- BCMath
- Ctype
- cURL
- DOM
- Fileinfo
- JSON
- Mbstring
- OpenSSL
- PCRE
- PDO
- PDO_MySQL
- Tokenizer
- XML

## Langkah Instalasi

### 1. Persiapan

#### Windows (Menggunakan XAMPP)
1. Download dan install XAMPP dari [https://www.apachefriends.org](https://www.apachefriends.org)
2. Pastikan PHP versi 8.1 atau lebih tinggi terinstall
3. Download dan install Composer dari [https://getcomposer.org](https://getcomposer.org)

#### Linux/Mac
1. Install PHP 8.1+, MySQL, dan Composer
2. Pastikan semua ekstensi PHP yang diperlukan sudah aktif

### 2. Extract Project

#### Windows
```
1. Copy folder sistem-cuti-pegawai ke C:\xampp\htdocs\
2. Rename folder menjadi "sistem-cuti-pegawai" (opsional)
```

#### Linux/Mac
```bash
# Extract ke folder web server
sudo cp -r sistem-cuti-pegawai /var/www/html/

# Atau menggunakan git
cd /var/www/html
git clone [url-repository] sistem-cuti-pegawai
```

### 3. Install Dependencies

Buka terminal/command prompt dan navigasi ke folder project:

```bash
cd C:\xampp\htdocs\sistem-cuti-pegawai

# Install dependencies
composer install
```

**Catatan**: Jika terjadi error memory limit, jalankan:
```bash
php -d memory_limit=-1 C:\ProgramData\ComposerSetup\bin\composer.phar install
```

### 4. Konfigurasi Environment

#### Copy file environment
```bash
copy .env.example .env
```

#### Edit file .env
Buka file `.env` dengan text editor dan sesuaikan konfigurasi:

```env
APP_NAME="Sistem Cuti Pegawai"
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost

DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=sistem_cuti_pegawai
DB_USERNAME=root
DB_PASSWORD=
```

**Catatan**: 
- Jika menggunakan XAMPP default, password MySQL biasanya kosong
- Sesuaikan `DB_DATABASE` dengan nama database yang akan dibuat

### 5. Generate Application Key

```bash
php artisan key:generate
```

### 6. Buat Database

#### Menggunakan phpMyAdmin
1. Buka browser dan akses: http://localhost/phpmyadmin
2. Klik "New" atau "Database"
3. Masukkan nama database: `sistem_cuti_pegawai`
4. Klik "Create"

#### Menggunakan Command Line
```bash
# Login ke MySQL
mysql -u root -p

# Buat database
CREATE DATABASE sistem_cuti_pegawai;

# Exit
EXIT;
```

### 7. Run Migration dan Seeder

```bash
# Jalankan migration dan seeder sekaligus
php artisan migrate --seed
```

Atau terpisah:
```bash
# Jalankan migration
php artisan migrate

# Jalankan seeder
php artisan db:seed
```

### 8. Buat Storage Link

```bash
php artisan storage:link
```

### 9. Konfigurasi Folder Permissions (Linux/Mac)

```bash
# Set permission untuk storage dan bootstrap/cache
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache

# Set ownership (sesuaikan dengan user web server)
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
```

### 10. Jalankan Aplikasi

#### Development Server
```bash
php artisan serve
```

Akses aplikasi di: http://localhost:8000

#### Production (XAMPP)
1. Pastikan Apache dan MySQL running di XAMPP Control Panel
2. Akses aplikasi di: http://localhost/sistem-cuti-pegawai/public

## Default Login

Setelah instalasi berhasil, gunakan akun berikut untuk login:

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@setda.go.id | password |
| Atasan | atasan@setda.go.id | password |
| Pegawai | pegawai@setda.go.id | password |

## Troubleshooting

### Error: Class not found
```bash
composer dump-autoload
```

### Error: PSR-4 autoloading
```bash
composer dump-autoload -o
```

### Error: Permission denied (Linux/Mac)
```bash
sudo chmod -R 775 storage
sudo chmod -R 775 bootstrap/cache
```

### Error: Key too long (MySQL < 5.7.7)
Sudah dihandle di `AppServiceProvider.php` dengan:
```php
Schema::defaultStringLength(191);
```

### Error: Failed to open stream: Permission denied
Pastikan folder `storage` dan `bootstrap/cache` writable:
```bash
# Windows: Right-click folder → Properties → Security → Edit → Add → Everyone → Full Control

# Linux/Mac:
sudo chmod -R 777 storage
sudo chmod -R 777 bootstrap/cache
```

### Error: SQLSTATE[HY000] [1049] Unknown database
Pastikan database sudah dibuat di phpMyAdmin atau MySQL

### Error: 500 Server Error
1. Check file `.env` sudah ada
2. Check `APP_KEY` sudah di-generate
3. Check database connection di `.env`
4. Check folder permissions

### Error: The stream or file "laravel.log" could not be opened
```bash
# Windows: Buat folder logs di storage jika belum ada
mkdir storage\logs

# Linux/Mac:
touch storage/logs/laravel.log
sudo chmod 666 storage/logs/laravel.log
```

## Konfigurasi Tambahan

### Konfigurasi Timezone
File `config/app.php`:
```php
'timezone' => 'Asia/Jakarta',
'locale' => 'id',
```

### Konfigurasi Email (Opsional)
Edit file `.env`:
```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"
```

## Update Aplikasi

Jika ada update dari developer:

```bash
# Pull latest changes
git pull origin main

# Update dependencies
composer install

# Run migration
php artisan migrate

# Clear cache
php artisan cache:clear
php artisan config:clear
php artisan view:clear
```

## Backup Database

### Menggunakan phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database `sistem_cuti_pegawai`
3. Klik "Export"
4. Pilih "Custom" method
5. Klik "Go"

### Menggunakan Command Line
```bash
mysqldump -u root -p sistem_cuti_pegawai > backup_$(date +%Y%m%d_%H%M%S).sql
```

## Restore Database

### Menggunakan phpMyAdmin
1. Buka phpMyAdmin
2. Pilih database (atau buat baru)
3. Klik "Import"
4. Pilih file SQL backup
5. Klik "Go"

### Menggunakan Command Line
```bash
mysql -u root -p sistem_cuti_pegawai < backup_file.sql
```

## Maintenance Mode

```bash
# Enable maintenance mode
php artisan down

# Disable maintenance mode
php artisan up
```

## Clear Cache

```bash
# Clear application cache
php artisan cache:clear

# Clear config cache
php artisan config:clear

# Clear route cache
php artisan route:clear

# Clear view cache
php artisan view:clear

# Clear all cache
php artisan optimize:clear
```

## Support

Jika mengalami kendala dalam instalasi, silakan hubungi:
- Email: [email-support]
- Telepon: [nomor-telepon]

## Lisensi

Aplikasi ini dikembangkan untuk keperluan internal Bagian Tata Pemerintahan (Tatapem) SETDA.
