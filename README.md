<p align="center">
  <h1 align="center">Sistem Absensi Kegiatan 🗓️</h1>
  <p align="center">
    Aplikasi web untuk manajemen absensi kegiatan, dibangun dengan Laravel & Vite.
    <br />
    <a href="#-memulai"><strong>Memulai »</strong></a>
    <br />
    <br />
    <a href="https://github.com/USERNAME/REPO/issues">Laporkan Bug</a>
    ·
    <a href="https://github.com/USERNAME/REPO/pulls">Request Fitur</a>
  </p>
</p>

<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
    <img src="https://img.shields.io/badge/PHP-8.1%2B-777BB4.svg?style=for-the-badge&logo=php" alt="PHP Version">
    <img src="https://img.shields.io/badge/Laravel-11.x-FF2D20.svg?style=for-the-badge&logo=laravel" alt="Laravel Version">
    <img src="https://img.shields.io/badge/Vite-5.x-646CFF.svg?style=for-the-badge&logo=vite" alt="Vite Version">
    <img src="https://img.shields.io/badge/License-MIT-green.svg?style=for-the-badge" alt="License">
    <img src="https://img.shields.io/badge/javascript-2025-F7DF1E.svg?style=for-the-badge&logo=javascript" alt="JavaScript">
    <img src="https://img.shields.io/badge/npm-latest-CB3837.svg?style=for-the-badge&logo=npm" alt="NPM">
</p>



---

### Daftar Isi
1.  [✨ Fitur Utama](#-fitur-utama)
2.  [🛠️ Teknologi yang Digunakan](#️-teknologi-yang-digunakan)
3.  [🚀 Memulai](#-memulai)
    * [Persyaratan Sistem](#persyaratan-sistem)
    * [Langkah Instalasi](#langkah-instalasi)
4.  [📖 Panduan Penggunaan](#-panduan-penggunaan)
5.  [📂 Struktur Proyek](#-struktur-proyek)
6.  [🌱 Rencana Pengembangan](#-rencana-pengembangan)
7.  [🤝 Kontribusi](#-kontribusi)
8.  [📜 Lisensi](#-lisensi)

---

## ✨ Fitur Utama
* **🔐 Autentikasi Pengguna:** Sistem login dan registrasi yang aman.
* **📝 Manajemen Absensi:** Pengguna dapat melihat daftar kegiatan dan melakukan absensi.
* **📊 Detail & Riwayat:** Melihat riwayat dan detail absensi yang telah dilakukan.
* **🖱️ Tampilan Data Interaktif:** Menggunakan [Yajra DataTables](httpss://yajrabox.com/docs/laravel-datatables/master) untuk tabel yang dinamis.
* **🖋️ Tanda Tangan Digital:** Fitur untuk mengunggah tanda tangan sebagai bukti kehadiran.

---

## 🛠️ Teknologi yang Digunakan
* **[PHP 8.1](https://www.php.net/)**
* **[Laravel 11](https://laravel.com/)**
* **[Vite](https://vitejs.dev/)**
* **Database:** SQLite (default), MySQL, atau PostgreSQL.
* **Frontend:** HTML, CSS, JavaScript.

---

## 🚀 Memulai

Untuk menjalankan proyek ini di lingkungan lokal Anda, ikuti langkah-langkah berikut.

### Persyaratan Sistem
Pastikan perangkat lunak berikut telah terinstal di sistem Anda:
* PHP >= 8.1
* Composer
* Node.js & NPM / Yarn

### Langkah Instalasi
1.  **Clone Repositori**
    ```bash
    git clone [https://github.com/USERNAME/REPO.git](https://github.com/USERNAME/REPO.git)
    cd NAMA_DIREKTORI_PROYEK
    ```

2.  **Instal Dependensi PHP**
    ```bash
    composer install
    ```

3.  **Konfigurasi Lingkungan**
    Salin file `.env.example` menjadi `.env` dan sesuaikan koneksi database Anda di dalamnya.
    ```bash
    cp .env.example .env
    ```
    Jika menggunakan SQLite (default), buat file database kosong:
    ```bash
    touch database/database.sqlite
    ```

4.  **Buat Kunci Aplikasi**
    ```bash
    php artisan key:generate
    ```

5.  **Jalankan Migrasi Database**
    Ini akan membuat semua tabel yang dibutuhkan oleh aplikasi.
    ```bash
    php artisan migrate
    ```

6.  **Instal Dependensi & Kompilasi Aset Frontend**
    ```bash
    npm install
    npm run dev
    ```
    *Gunakan `npm run build` untuk lingkungan produksi.*

---

## 📖 Panduan Penggunaan

Setelah instalasi berhasil, ikuti alur penggunaan dasar berikut:

1.  **Jalankan Server Pengembangan**
    Di direktori root proyek, jalankan perintah:
    ```bash
    php artisan serve
    ```
    Aplikasi akan berjalan di `http://127.0.0.1:8000`.

2.  **Registrasi & Login**
    * Buka aplikasi di browser.
    * Buat akun baru melalui halaman **"Register"** atau masuk jika sudah punya akun.

3.  **Melakukan Absensi**
    * Setelah login, Anda akan melihat daftar kegiatan yang tersedia.
    * Pilih salah satu kegiatan untuk melihat detail dan melakukan absensi.
    * Jika diperlukan, Anda dapat **menggambar tanda tangan digital** di area yang disediakan.
    * Klik **"Submit"** untuk menyimpan data kehadiran Anda.

4.  **Melihat Riwayat**
    * Navigasikan ke halaman riwayat untuk melihat semua absensi yang pernah Anda lakukan.

---

## 📂 Struktur Proyek

Berikut adalah gambaran umum komponen-komponen kunci dalam proyek Laravel ini.

* `app/Http/Controllers/` - Berisi logika untuk menangani permintaan HTTP.
    * `AbsenController.php`: Mengelola halaman daftar kegiatan.
    * `PrasenceController.php`: Menangani proses simpan data kehadiran.
* `app/Models/` - Berisi model Eloquent untuk interaksi dengan database.
    * `Prasence.php`: Merepresentasikan sebuah kegiatan.
    * `PrasenceDetail.php`: Merepresentasikan data absensi per pengguna.
* `app/DataTables/` - Kelas untuk integrasi server-side dengan Yajra DataTables.
* `database/migrations/` - Berisi skema struktur database aplikasi.
* `resources/views/` - Berisi semua template Blade untuk antarmuka pengguna.
* `routes/web.php` - Tempat mendefinisikan semua rute web untuk aplikasi.

<details>
<summary>Klik untuk melihat struktur direktori lengkap</summary>
