# Project Summary - Sistem Cuti Pegawai Online

## Overview
Project Laravel lengkap untuk Sistem Cuti Pegawai Online yang dikembangkan untuk Bagian Tata Pemerintahan (Tatapem) SETDA.

## Struktur Project

```
sistem-cuti-pegawai/
├── app/
│   ├── Console/Kernel.php
│   ├── Exceptions/Handler.php
│   ├── Exports/CutiExport.php
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/LoginController.php
│   │   │   ├── Admin/AdminController.php
│   │   │   ├── Atasan/AtasanController.php
│   │   │   └── Pegawai/PegawaiController.php
│   │   ├── Kernel.php
│   │   └── Middleware/
│   │       ├── Authenticate.php
│   │       ├── EncryptCookies.php
│   │       ├── PreventRequestsDuringMaintenance.php
│   │       ├── RedirectIfAuthenticated.php
│   │       ├── RoleMiddleware.php
│   │       ├── TrimStrings.php
│   │       ├── TrustHosts.php
│   │       ├── TrustProxies.php
│   │       ├── ValidateSignature.php
│   │       └── VerifyCsrfToken.php
│   ├── Models/
│   │   ├── User.php
│   │   └── Cuti.php
│   └── Providers/
│       ├── AppServiceProvider.php
│       ├── AuthServiceProvider.php
│       ├── EventServiceProvider.php
│       └── RouteServiceProvider.php
├── bootstrap/
│   ├── app.php
│   └── cache/.gitignore
├── config/
│   ├── app.php
│   ├── auth.php
│   ├── broadcasting.php
│   ├── cache.php
│   ├── cors.php
│   ├── database.php
│   ├── dompdf.php
│   ├── excel.php
│   ├── filesystems.php
│   ├── hashing.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── sanctum.php
│   ├── services.php
│   ├── session.php
│   └── view.php
├── database/
│   ├── factories/
│   │   ├── UserFactory.php
│   │   └── CutiFactory.php
│   ├── migrations/
│   │   ├── 2014_10_12_000000_create_users_table.php
│   │   ├── 2014_10_12_100000_create_password_resets_table.php
│   │   ├── 2019_12_14_000001_create_personal_access_tokens_table.php
│   │   └── 2024_01_15_000001_create_cuti_table.php
│   └── seeders/
│       ├── DatabaseSeeder.php
│       └── UserSeeder.php
├── lang/
│   ├── en/
│   │   ├── auth.php
│   │   ├── pagination.php
│   │   ├── passwords.php
│   │   └── validation.php
│   └── id/
│       ├── auth.php
│       ├── pagination.php
│       ├── passwords.php
│       └── validation.php
├── public/
│   ├── css/app.css
│   ├── js/app.js
│   ├── favicon.ico
│   ├── index.php
│   ├── robots.txt
│   ├── .htaccess
│   └── web.config
├── resources/
│   ├── css/app.css
│   ├── js/
│   │   ├── app.js
│   │   └── bootstrap.js
│   └── views/
│       ├── admin/
│       │   ├── dashboard.blade.php
│       │   ├── cuti/
│       │   │   ├── index.blade.php
│       │   │   └── pdf.blade.php
│       │   └── users/
│       │       ├── index.blade.php
│       │       ├── create.blade.php
│       │       └── edit.blade.php
│       ├── atasan/
│       │   ├── dashboard.blade.php
│       │   └── pengajuan/
│       │       ├── index.blade.php
│       │       └── show.blade.php
│       ├── auth/
│       │   └── login.blade.php
│       ├── layouts/
│       │   ├── app.blade.php
│       │   ├── sidebar.blade.php
│       │   └── topbar.blade.php
│       └── pegawai/
│           ├── dashboard.blade.php
│           └── cuti/
│               ├── create.blade.php
│               ├── riwayat.blade.php
│               ├── show.blade.php
│               └── sisa.blade.php
├── routes/
│   ├── api.php
│   ├── console.php
│   └── web.php
├── storage/
│   ├── app/
│   │   ├── .gitignore
│   │   └── public/.gitignore
│   ├── framework/
│   │   ├── cache/data/.gitignore
│   │   ├── sessions/.gitignore
│   │   ├── testing/.gitignore
│   │   ├── views/.gitignore
│   │   └── .gitignore
│   └── logs/.gitignore
├── tests/
│   ├── CreatesApplication.php
│   ├── TestCase.php
│   ├── Feature/ExampleTest.php
│   └── Unit/ExampleTest.php
├── .editorconfig
├── .env.example
├── .gitignore
├── artisan
├── CHANGELOG.md
├── composer.json
├── INSTALL.md
├── LICENSE
├── package.json
├── phpunit.xml
├── PROJECT_SUMMARY.md
├── README.md
└── vite.config.js
```

## File Count Summary

### PHP Files
- **Controllers**: 5 files
- **Models**: 2 files
- **Middleware**: 9 files
- **Providers**: 4 files
- **Exports**: 1 file
- **Config**: 16 files

### Database Files
- **Migrations**: 4 files
- **Seeders**: 2 files
- **Factories**: 2 files

### View Files (Blade)
- **Layouts**: 3 files
- **Auth**: 1 file
- **Admin**: 5 files
- **Atasan**: 3 files
- **Pegawai**: 5 files

### Other Files
- **Routes**: 3 files
- **Lang**: 8 files
- **Public**: 7 files
- **Tests**: 4 files
- **Config**: 16 files

**Total Files**: ~100+ files

## Instalasi Cepat

```bash
# 1. Install dependencies
composer install

# 2. Copy environment file
cp .env.example .env

# 3. Generate application key
php artisan key:generate

# 4. Buat database di MySQL (nama: sistem_cuti_pegawai)

# 5. Run migration dan seeder
php artisan migrate --seed

# 6. Jalankan aplikasi
php artisan serve
```

## Default Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@setda.go.id | password |
| Atasan | atasan@setda.go.id | password |
| Pegawai | pegawai@setda.go.id | password |

## Fitur Utama

### 1. Multi Role Authentication
- Login dengan role-based redirect
- Middleware role custom
- Session management

### 2. CRUD Pegawai (Admin)
- Tambah, edit, hapus pegawai
- Set jatah cuti
- Filter dan search

### 3. Pengajuan Cuti (Pegawai)
- Cuti Tahunan, Cuti Sakit, Izin
- Upload file pendukung
- Validasi sisa cuti
- Hitung otomatis jumlah hari

### 4. Approval System (Atasan)
- Approve/Reject pengajuan
- Catatan penolakan
- Filter pengajuan

### 5. Export Laporan (Admin)
- Export PDF
- Export Excel
- Filter per bulan/tahun/pegawai

### 6. Dashboard
- Statistik per role
- Riwayat terbaru
- Akses cepat

## Teknologi

- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: Bootstrap 5 + Blade
- **Export**: DomPDF + Maatwebsite Excel
- **Auth**: Laravel Breeze (modified)

## Lisensi

MIT License - Bagian Tata Pemerintahan (Tatapem) SETDA
