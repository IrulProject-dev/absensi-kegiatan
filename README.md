# Sistem Absensi Kegiatan 🗓️

Aplikasi web untuk manajemen absensi kegiatan berbasis Laravel dan Vite dengan fitur tanda tangan digital.

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4.svg?style=for-the-badge&logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel Version">
    <img src="https://img.shields.io/badge/Vite-5.x-646CFF.svg?style=for-the-badge&logo=vite" alt="Vite Version">
    <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License">
    <img src="https://img.shields.io/badge/javascript-2025-F7DF1E.svg?style=for-the-badge&logo=javascript" alt="JavaScript">
    <img src="https://img.shields.io/badge/npm-latest-CB3837.svg?style=for-the-badge&logo=npm" alt="NPM">
</p>

## Daftar Isi
- [Fitur Utama](#-fitur-utama)
- [Teknologi](#-teknologi)
- [Instalasi](#-instalasi)
- [Penggunaan](#-penggunaan)
- [Struktur Proyek](#-struktur-proyek)
- [Kontribusi](#-kontribusi)
- [Lisensi](#-lisensi)

## ✨ Fitur Utama
- **Sistem Autentikasi** 🔐
  - Registrasi dan login pengguna
  - Proteksi halaman admin
- **Manajemen Kegiatan** 📅
  - Buat/jadwalkan kegiatan
  - Edit informasi kegiatan
- **Absensi Digital** ✔️
  - Presensi online
  - Validasi kehadiran
- **Tanda Tangan Elektronik** ✍️
  - Fitur gambar tanda tangan langsung
  - Penyimpanan tanda tangan aman
- **Laporan** 📊
  - Ekspor data ke Excel/PDF
  - Statistik kehadiran

## 🛠️ Teknologi
**Backend:**
- Laravel 11
- PHP 8.1+
- Yajra DataTables

**Frontend:**
- Vite 5
- Bootstrap 5
- Signature Pad

**Database:**
- SQLite (default)
- MySQL/PostgreSQL

## 🚀 Instalasi

### Persyaratan
- PHP 8.1+
- Composer
- Node.js 16+
- Database (SQLite/MySQL/PostgreSQL)

### Langkah-langkah
1. Clone repositori:
   ```bash
   git clone https://github.com/username/absensi-kegiatan.git
   cd absensi-kegiatan
   ```

2. Install dependensi:
   ```bash
   composer install
   npm install
   ```

3. Setup environment:
   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

4. Konfigurasi database (`.env`):
   ```env
   DB_CONNECTION=sqlite
   # Untuk MySQL:
   # DB_CONNECTION=mysql
   # DB_HOST=127.0.0.1
   # DB_PORT=3306
   # DB_DATABASE=absensi
   # DB_USERNAME=root
   # DB_PASSWORD=
   ```

5. Migrasi database:
   ```bash
   php artisan migrate
   ```

6. Jalankan development server:
   ```bash
   npm run dev
   php artisan serve
   ```

Buka http://localhost:8000 di browser.

## 📖 Penggunaan

### Untuk Pengguna
1. **Registrasi/Login**
   - Daftar akun baru atau login

2. **Absensi Kegiatan**
   - Pilih kegiatan
   - Isi formulir
   - Gambar tanda tangan
   - Submit

3. **Lihat Riwayat**
   - Cek history absensi
   - Detail presensi

### Untuk Admin
1. **Kelola Kegiatan**
   - Tambah kegiatan baru
   - Edit jadwal

2. **Kelola Pengguna**
   - Daftar pengguna
   - Reset password

3. **Generate Laporan**
   - Export data
   - Statistik

## 📂 Struktur Proyek
```
absensi-kegiatan/
├── app/
│   ├── Http/Controllers/
│   ├── Models/
│   └── DataTables/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   ├── uploads/
│   └── build/
├── resources/
│   ├── views/
│   └── js/
├── routes/
├── tests/
└── vendor/
```

## 🤝 Kontribusi
Kontribusi terbuka! Ikuti langkah:
1. Fork project
2. Buat branch baru
3. Commit perubahan
4. Push ke branch
5. Buat Pull Request

## 📜 Lisensi
MIT License - Lihat [LICENSE](LICENSE) untuk detail lengkap.

---

Dibuat dengan ❤️ menggunakan Laravel dan Vite.
