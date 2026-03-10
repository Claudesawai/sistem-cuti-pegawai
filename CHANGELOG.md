# Changelog

All notable changes to this project will be documented in this file.

## [1.0.0] - 2024-01-15

### Added
- Initial release of Sistem Cuti Pegawai Online
- Multi-role authentication (Admin, Atasan, Pegawai)
- CRUD Data Pegawai for Admin
- Pengajuan Cuti (Cuti Tahunan, Cuti Sakit, Izin) for Pegawai
- Approval/Rejection system for Atasan
- Dashboard with statistics for each role
- Export to PDF and Excel functionality
- File upload support for cuti submissions
- Automatic calculation of jumlah hari
- Sisa cuti tracking and validation
- Filter and search functionality
- Responsive design with Bootstrap 5
- Indonesian localization

### Features
- **Admin**
  - Dashboard with statistics
  - CRUD Pegawai
  - View all cuti data
  - Export laporan (PDF & Excel)
  - Filter by date, status, jenis cuti

- **Atasan**
  - Dashboard with statistics
  - View pengajuan cuti
  - Approve/Reject cuti
  - Add catatan for rejection
  - Filter pengajuan

- **Pegawai**
  - Dashboard with sisa cuti info
  - Ajukan cuti
  - View riwayat cuti
  - Check sisa cuti
  - Upload file pendukung

### Technical
- Laravel 10.x framework
- PHP 8.1+ requirement
- MySQL/MariaDB database
- Bootstrap 5 frontend
- Blade templating engine
- DomPDF for PDF export
- Maatwebsite Excel for Excel export
