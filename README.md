# Sistem Cuti Pegawai Online

Sistem Cuti Pegawai Online adalah aplikasi web berbasis Laravel yang dikembangkan untuk membantu Bagian Tata Pemerintahan (Tatapem) SETDA dalam mengelola pengajuan cuti pegawai yang sebelumnya masih dilakukan secara manual.

## Fitur Utama

### 1. Authentication Multi Role
- **Admin**: Mengelola data pegawai dan melihat laporan
- **Atasan**: Menyetujui atau menolak pengajuan cuti
- **Pegawai**: Mengajukan cuti dan melihat riwayat

### 2. Fitur Pegawai
- Login ke sistem
- Ajukan cuti (Cuti Tahunan, Cuti Sakit, Izin)
- Input tanggal mulai, tanggal selesai, alasan
- Upload file pendukung (opsional)
- Sistem otomatis menghitung jumlah hari
- Validasi sisa cuti tidak cukup
- Lihat status pengajuan (Menunggu, Disetujui, Ditolak)
- Lihat riwayat cuti
- Lihat sisa cuti tahunan

### 3. Fitur Atasan
- Lihat daftar pengajuan bawahan
- Approve/Reject pengajuan
- Beri catatan saat menolak
- Filter berdasarkan tanggal dan jenis cuti
- Dashboard statistik sederhana

### 4. Fitur Admin
- CRUD Data Pegawai
- Set jatah cuti tahunan default 12 hari
- Lihat semua data cuti
- Export laporan (PDF dan Excel)
- Filter per bulan, tahun, dan pegawai

## Struktur Database

### Tabel Users
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| name | varchar | Nama lengkap |
| email | varchar | Email (unique) |
| password | varchar | Password hash |
| role | enum | admin, atasan, pegawai |
| jabatan | varchar | Jabatan |
| sisa_cuti | int | Sisa cuti tahunan |
| created_at | timestamp | Tanggal dibuat |
| updated_at | timestamp | Tanggal diupdate |

### Tabel Cuti
| Field | Type | Description |
|-------|------|-------------|
| id | bigint | Primary key |
| user_id | bigint | Foreign key ke users |
| jenis_cuti | enum | cuti_tahunan, cuti_sakit, izin |
| tanggal_mulai | date | Tanggal mulai cuti |
| tanggal_selesai | date | Tanggal selesai cuti |
| jumlah_hari | int | Jumlah hari cuti |
| alasan | text | Alasan cuti |
| file_pendukung | varchar | Path file pendukung |
| status | enum | menunggu, disetujui, ditolak |
| catatan_atasan | text | Catatan dari atasan |
| approved_by | bigint | Foreign key ke users (atasan) |
| created_at | timestamp | Tanggal dibuat |
| updated_at | timestamp | Tanggal diupdate |

## Entity Relationship Diagram (ERD)

```
+------------+       +------------+
|   users    |       |    cuti    |
+------------+       +------------+
| id (PK)    |<-----| user_id    |
| name       |       | id (PK)    |
| email      |       | jenis_cuti |
| password   |       | tgl_mulai  |
| role       |       | tgl_selesai|
| jabatan    |       | jumlah_hari|
| sisa_cuti  |       | alasan     |
| created_at |       | file       |
| updated_at |       | status     |
+------------+       | catatan    |
       ^             | approved_by|------+
       |             | created_at |      |
       |             | updated_at |      |
       |             +------------+      |
       |                                 |
       +---------------------------------+
```

## Use Case Diagram

```
+------------------+
|     PEGAWAI      |
+------------------+
| - Login          |
| - Ajukan Cuti    |
| - Lihat Riwayat  |
| - Cek Sisa Cuti  |
+------------------+
         |
         v
+------------------+
|     ATASAN       |
+------------------+
| - Login          |
| - Lihat Pengajuan|
| - Approve Cuti   |
| - Reject Cuti    |
| - Dashboard      |
+------------------+
         |
         v
+------------------+
|      ADMIN       |
+------------------+
| - Login          |
| - CRUD Pegawai   |
| - Lihat Cuti     |
| - Export PDF     |
| - Export Excel   |
| - Dashboard      |
+------------------+
```

## Flowchart Pengajuan Cuti

```
+----------------+
|     Start      |
+----------------+
        |
        v
+----------------+
|  Login Pegawai |
+----------------+
        |
        v
+----------------+
|  Pilih Jenis   |
|     Cuti       |
+----------------+
        |
        v
+----------------+
|  Input Tanggal |
|   dan Alasan   |
+----------------+
        |
        v
+----------------+
|  Validasi      |
|  Sisa Cuti     |
+----------------+
        |
    +---+---+
    |       |
    v       v
+------+  +------+
|Cukup |  |Tidak |
+------+  +------+
    |       |
    v       v
+------+  +----------------+
|Submit|  |Tampilkan Error |
+------+  +----------------+
    |       |
    v       v
+------+  +------+
|Status|  | Kembali
|Menunggu      |
+------+
    |
    v
+----------------+
| Atasan Review  |
+----------------+
    |
    +-----+-----+
    |           |
    v           v
+--------+  +--------+
|Setuju  |  | Tolak  |
+--------+  +--------+
    |           |
    v           v
+--------+  +--------+
|Status  |  |Status  |
|Disetujui    Ditolak
+--------+  +--------+
    |           |
    v           v
+--------+  +--------+
|Sisa    |  |Sisa    |
|Cuti -  |  |Cuti    |
|Jumlah  |  |Tetap   |
+--------+  +--------+
    |
    v
+----------------+
|      End       |
+----------------+
```

## Cara Instalasi di XAMPP

### Persyaratan
- PHP >= 8.1
- MySQL/MariaDB
- Composer
- XAMPP

### Langkah Instalasi

1. **Clone atau Extract Project**
   ```bash
   # Extract file project ke folder htdocs XAMPP
   # Contoh: C:\xampp\htdocs\sistem-cuti-pegawai
   ```

2. **Install Dependencies**
   ```bash
   cd C:\xampp\htdocs\sistem-cuti-pegawai
   composer install
   ```

3. **Copy Environment File**
   ```bash
   cp .env.example .env
   ```

4. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

5. **Konfigurasi Database**
   
   Edit file `.env` dan sesuaikan konfigurasi database:
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=sistem_cuti_pegawai
   DB_USERNAME=root
   DB_PASSWORD=
   ```

6. **Buat Database**
   
   Buka phpMyAdmin (http://localhost/phpmyadmin) dan buat database baru dengan nama `sistem_cuti_pegawai`

7. **Run Migration dan Seeder**
   ```bash
   php artisan migrate --seed
   ```

8. **Buat Storage Link**
   ```bash
   php artisan storage:link
   ```

9. **Jalankan Aplikasi**
   ```bash
   php artisan serve
   ```

10. **Akses Aplikasi**
    
    Buka browser dan akses: http://localhost:8000

### Default Login

| Role | Email | Password |
|------|-------|----------|
| Admin | admin@setda.go.id | password |
| Atasan | atasan@setda.go.id | password |
| Pegawai | pegawai@setda.go.id | password |

### Troubleshooting

1. **Error: Class not found**
   ```bash
   composer dump-autoload
   ```

2. **Error: Permission denied**
   - Pastikan folder `storage` dan `bootstrap/cache` writable
   ```bash
   chmod -R 775 storage
   chmod -R 775 bootstrap/cache
   ```

3. **Error: Key too long**
   - Sudah dihandle di AppServiceProvider dengan `Schema::defaultStringLength(191)`

4. **Error: PSR-4**
   ```bash
   composer dump-autoload
   ```

## Struktur Folder

```
sistem-cuti-pegawai/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Exports/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   ├── Admin/
│   │   │   ├── Atasan/
│   │   │   └── Pegawai/
│   │   └── Middleware/
│   ├── Models/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   ├── factories/
│   ├── migrations/
│   └── seeders/
├── public/
├── resources/
│   └── views/
│       ├── admin/
│       ├── atasan/
│       ├── auth/
│       ├── layouts/
│       └── pegawai/
├── routes/
├── storage/
└── tests/
```

## Teknologi yang Digunakan

- **Framework**: Laravel 10.x
- **PHP**: 8.1+
- **Database**: MySQL/MariaDB
- **Frontend**: Blade Template + Bootstrap 5
- **Authentication**: Laravel Breeze (modified)
- **Export PDF**: Barryvdh Laravel DomPDF
- **Export Excel**: Maatwebsite Excel

## License

This project is open-sourced software licensed under the MIT license.

## Kontak

Bagian Tata Pemerintahan (Tatapem) SETDA
