# Sistem Absensi Kegiatan

Aplikasi web ini adalah sistem absensi kegiatan yang dibangun dengan Laravel dan Vite. Aplikasi ini memungkinkan pengguna untuk melihat daftar kegiatan, melakukan absensi, dan melihat detail absensi mereka.

## Fitur Utama

*   **Autentikasi Pengguna:** Sistem login dan registrasi untuk mengelola akses pengguna.
*   **Manajemen Absensi:** Pengguna dapat melihat daftar kegiatan yang tersedia dan melakukan absensi.
*   **Detail Absensi:** Melihat riwayat dan detail absensi yang telah dilakukan.
*   **Tampilan Data Interaktif:** Menggunakan Yajra DataTables untuk menampilkan data dalam format tabel yang mudah diurutkan dan dicari.
*   **Tanda Tangan Digital:** Kemungkinan fitur untuk mengunggah tanda tangan digital sebagai bagian dari proses absensi.

## Persyaratan Sistem

Pastikan Anda memiliki perangkat lunak berikut terinstal di sistem Anda:

*   PHP >= 8.1
*   Composer
*   Node.js & NPM (atau Yarn)
*   Database (MySQL, PostgreSQL, SQLite, dll. - SQLite digunakan secara default dalam contoh ini)

## Instalasi

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan proyek di lingkungan lokal Anda:

1.  **Clone Repositori:**
    ```bash
    git clone <URL_REPOSITORI_ANDA>
    cd absensi-kegiatan
    ```

2.  **Instal Dependensi PHP:**
    ```bash
    composer install
    ```

3.  **Konfigurasi Lingkungan:**
    Salin file `.env.example` menjadi `.env`:
    ```bash
    cp .env.example .env
    ```
    Buka file `.env` dan sesuaikan pengaturan database Anda. Secara default, proyek ini menggunakan SQLite. Jika Anda ingin menggunakan database lain (misalnya MySQL), ubah baris berikut:
    ```dotenv
    DB_CONNECTION=sqlite
    # DB_CONNECTION=mysql
    # DB_HOST=127.0.0.1
    # DB_PORT=3306
    # DB_DATABASE=laravel
    # DB_USERNAME=root
    # DB_PASSWORD=
    ```
    Jika Anda menggunakan SQLite, pastikan file `database.sqlite` ada di direktori `database/`. Jika tidak, buatlah:
    ```bash
    touch database/database.sqlite
    ```

4.  **Buat Kunci Aplikasi:**
    ```bash
    php artisan key:generate
    ```

5.  **Jalankan Migrasi Database:**
    Ini akan membuat tabel-tabel yang diperlukan di database Anda.
    ```bash
    php artisan migrate
    ```

6.  **Instal Dependensi Node.js dan Kompilasi Aset Frontend:**
    ```bash
    npm install
    npm run dev
    # Atau untuk produksi:
    # npm run build
    ```

## Menjalankan Aplikasi

Setelah semua langkah instalasi selesai, Anda dapat menjalankan aplikasi menggunakan server pengembangan Laravel:

```bash
php artisan serve
```

Aplikasi akan tersedia di `http://127.0.0.1:8000` (atau port lain yang ditampilkan di konsol).

## Cara Penggunaan Proyek

Setelah Anda berhasil menginstal proyek mengikuti langkah-langkah di bagian **Instalasi**, berikut adalah alur penggunaan dasar proyek ini:

1.  **Mulai Server Pengembangan:**
    Pastikan Anda berada di direktori root proyek (`absensi-kegiatan`).
    ```bash
    php artisan serve
    ```
    Ini akan memulai server web lokal Laravel.

2.  **Akses Aplikasi di Browser:**
    Buka browser web Anda dan navigasikan ke alamat yang ditampilkan di konsol (biasanya `http://127.0.0.1:8000`).

3.  **Login atau Registrasi:**
    *   Jika Anda belum memiliki akun, klik tautan "Register" untuk membuat akun baru.
    *   Jika Anda sudah memiliki akun, masukkan kredensial Anda di halaman login.

4.  **Navigasi dan Interaksi:**
    Setelah berhasil login, Anda akan diarahkan ke dashboard atau halaman utama. Dari sana, Anda dapat mulai berinteraksi dengan fitur-fitur absensi.

## Alur Penggunaan Aplikasi (Contoh: Absensi dengan Tanda Tangan)

Berikut adalah contoh alur penggunaan aplikasi dari sisi pengguna, termasuk proses absensi dan input tanda tangan:

1.  **Akses Aplikasi dan Login:**
    *   Pengguna membuka aplikasi di browser (`http://127.0.0.1:8000`).
    *   Pengguna melakukan login menggunakan akun yang sudah terdaftar. Jika belum, pengguna dapat mendaftar terlebih dahulu.

2.  **Melihat Daftar Kegiatan Absensi:**
    *   Setelah login, pengguna akan melihat daftar kegiatan yang tersedia untuk absensi. Ini biasanya ditampilkan dalam bentuk tabel interaktif (menggunakan DataTables).
    *   Pengguna dapat mencari atau memfilter kegiatan berdasarkan kriteria tertentu.

3.  **Melakukan Absensi:**
    *   Pengguna memilih kegiatan yang ingin diabseni dari daftar.
    *   Pengguna mungkin akan diarahkan ke halaman detail kegiatan atau formulir absensi.
    *   Pada formulir absensi, pengguna akan diminta untuk mengisi informasi yang diperlukan.

4.  **Input Tanda Tangan (Jika Diperlukan):**
    *   Jika kegiatan memerlukan tanda tangan digital (misalnya, untuk "guest" atau jenis absensi tertentu), pengguna akan melihat area di mana mereka dapat menggambar tanda tangan mereka menggunakan mouse atau perangkat sentuh.
    *   Tanda tangan ini kemudian akan dikonversi menjadi gambar dan disimpan.

5.  **Konfirmasi dan Penyimpanan Absensi:**
    *   Setelah semua informasi (termasuk tanda tangan jika ada) diisi, pengguna mengklik tombol "Submit" atau "Absen".
    *   Data absensi akan disimpan ke database, dan pengguna akan menerima konfirmasi bahwa absensi mereka berhasil.

6.  **Melihat Riwayat Absensi:**
    *   Pengguna dapat kembali ke halaman riwayat absensi untuk melihat semua absensi yang telah mereka lakukan, termasuk detail dan tanda tangan yang telah diinput.

## Struktur Proyek

Berikut adalah gambaran umum struktur direktori dan file penting dalam proyek ini:

```
.
├── .editorconfig             # Konfigurasi editor untuk konsistensi gaya kode
├── .env.example              # Contoh file konfigurasi lingkungan
├── .gitattributes            # Atribut path untuk Git
├── .gitignore                # File/direktori yang diabaikan oleh Git
├── artisan                   # Skrip baris perintah Laravel
├── composer.json             # Dependensi PHP proyek
├── composer.lock             # Versi spesifik dependensi PHP
├── package-lock.json         # Versi spesifik dependensi Node.js
├── package.json              # Dependensi Node.js proyek dan skrip NPM
├── phpunit.xml               # Konfigurasi PHPUnit
├── README.md                 # Dokumentasi proyek ini
├── vite.config.js            # Konfigurasi Vite untuk aset frontend
├── app/                      # Direktori inti aplikasi
│   ├── DataTables/           # Kelas-kelas untuk Yajra DataTables
│   │   ├── AbsenDataTable.php
│   │   ├── prasenceDetailsDataTable.php
│   │   └── prasencesDataTable.php
│   ├── Http/                 # File-file yang menangani permintaan HTTP
│   │   └── Controllers/      # Controller aplikasi
│   │       ├── AbsenController.php
│   │       ├── Controller.php
│   │       ├── DashboardController.php
│   │       ├── HomeController.php
│   │       ├── PrasenceController.php
│   │       ├── prasenceDetailController.php
│   │       └── Auth/         # Controller autentikasi
│   ├── Models/               # Model Eloquent untuk interaksi database
│   │   ├── prasence.php
│   │   ├── prasenceDetail.php
│   │   └── User.php
│   └── Providers/            # Penyedia layanan aplikasi
│       └── AppServiceProvider.php
├── bootstrap/                # File-file bootstrap framework
│   ├── app.php
│   ├── providers.php
│   └── cache/                # Cache framework
├── config/                   # File konfigurasi aplikasi
│   ├── app.php
│   ├── auth.php
│   ├── cache.php
│   ├── database.php
│   ├── filesystems.php
│   ├── logging.php
│   ├── mail.php
│   ├── queue.php
│   ├── services.php
│   └── session.php
├── database/                 # Migrasi, seeder, dan factory database
│   ├── .gitignore
│   ├── database.sqlite       # File database SQLite (jika digunakan)
│   ├── factories/            # Factory model
│   │   └── UserFactory.php
│   ├── migrations/           # Migrasi database
│   │   ├── 0001_01_01_000000_create_users_table.php
│   │   ├── 0001_01_01_000001_create_cache_table.php
│   │   ├── 0001_01_01_000002_create_jobs_table.php
│   │   ├── 2025_07_14_110940_create_prasences_table.php
│   │   ├── 2025_07_21_100602_create_prasence_details_table.php
│   │   └── 2025_07_25_031855_forign_key.php
│   └── seeders/              # Seeder database
│       └── DatabaseSeeder.php
├── node_modules/             # Dependensi Node.js
├── public/                   # Direktori root web (aset publik)
│   ├── .htaccess
│   ├── favicon.ico
│   ├── index.php
│   ├── robots.txt
│   ├── build/                # Aset frontend yang dikompilasi
│   ├── css/                  # File CSS kustom
│   │   └── icon-animations.css
│   ├── js/                   # File JavaScript kustom
│   │   ├── icon-animations.js
│   │   └── signature.min.js
│   └── uploads/              # File yang diunggah pengguna
│       └── tanda-tangan/     # Gambar tanda tangan
├── resources/                # Aset frontend (view, CSS, JS sumber)
│   ├── css/                  # File CSS sumber
│   │   └── app.css
│   ├── js/                   # File JavaScript sumber
│   │   ├── app.js
│   │   └── bootstrap.js
│   ├── sass/                 # File SASS/SCSS sumber
│   │   ├── _variables.scss
│   │   └── app.scss
│   ├── svgs/                 # File SVG
│   │   └── trash.svg
│   └── views/                # Template Blade
│       ├── home.blade.php
│       ├── welcome.blade.php
│       ├── auth/             # View autentikasi
│       ├── components/       # Komponen Blade
│       │   ├── animated-clipboard-icon.blade.php
│       │   └── animated-PDF-icon.blade.php
│       ├── layouts/          # Layout dasar
│       │   ├── app.blade.php
│       │   └── main.blade.php
│       └── pages/            # View halaman spesifik
│           ├── index.blade.php
│           ├── absen/
│           └── prasence/
├── routes/                   # Definisi rute aplikasi
│   ├── console.php
│   └── web.php
├── storage/                  # File yang dihasilkan framework (sesi, cache, log)
│   ├── app/
│   ├── framework/
│   └── logs/
├── tests/                    # Pengujian otomatis
│   ├── TestCase.php
│   ├── Feature/
│   └── Unit/
└── vendor/                   # Dependensi PHP
```

## Komponen Kunci

### Controllers (`app/Http/Controllers/`)

*   **`AbsenController`**: Mengelola tampilan daftar kegiatan absensi dan detailnya.
*   **`PrasenceController`**: Menangani proses penyimpanan dan tampilan data kehadiran/prasensi.
*   **`PrasenceDetailController`**: Mengelola detail spesifik dari setiap absensi, seperti tanda tangan.
*   **`DashboardController` / `HomeController`**: Mengelola halaman utama atau dashboard aplikasi.

### Models (`app/Models/`)

*   **`User`**: Merepresentasikan pengguna aplikasi.
*   **`Prasence`**: Merepresentasikan kegiatan atau acara yang memerlukan absensi.
*   **`PrasenceDetail`**: Merepresentasikan catatan absensi individu untuk suatu kegiatan, termasuk informasi tambahan seperti tanda tangan.

### DataTables (`app/DataTables/`)

Kelas-kelas ini digunakan untuk mengintegrasikan data dari database dengan library DataTables, memungkinkan tampilan tabel yang kaya fitur (pencarian, pengurutan, paginasi) di sisi klien.

*   **`AbsenDataTable`**: Untuk daftar kegiatan absensi.
*   **`PrasencesDataTable`**: Untuk daftar kehadiran/prasensi.
*   **`PrasenceDetailsDataTable`**: Untuk detail kehadiran/prasensi.

### Views (`resources/views/`)

Menggunakan Blade templating engine Laravel.

*   **`layouts/app.blade.php` & `layouts/main.blade.php`**: Layout dasar yang mendefinisikan struktur umum halaman (header, footer, navigasi).
*   **`home.blade.php`**: Halaman beranda setelah login.
*   **`pages/absen/index.blade.php`**: Menampilkan daftar kegiatan yang dapat diabseni.
*   **`pages/absen/show.blade.php`**: Menampilkan detail kegiatan dan formulir untuk melakukan absensi.
*   **`pages/prasence/index.blade.php`**: Menampilkan daftar absensi yang sudah ada.
*   **`pages/prasence/show.blade.php`**: Menampilkan detail absensi yang sudah dilakukan.
*   **`components/`**: Berisi komponen-komponen UI yang dapat digunakan kembali di berbagai view.

## Potensi Peningkatan

*   **Validasi Input:** Menambahkan validasi input yang lebih kuat di sisi server untuk memastikan integritas data.
*   **Manajemen Peran:** Mengimplementasikan sistem peran untuk membedakan antara pengguna biasa dan administrator, dengan hak akses yang berbeda.
*   **Pengujian Otomatis:** Menambahkan pengujian unit dan fitur untuk memastikan fungsionalitas aplikasi berjalan seperti yang diharapkan dan mencegah regresi.
*   **Dokumentasi API:** Jika ada rencana untuk membuat API, dokumentasi API akan sangat membantu pengembang lain.
*   **Notifikasi:** Mengimplementasikan notifikasi (misalnya, email atau notifikasi dalam aplikasi) untuk peristiwa penting.
*   **Laporan:** Menambahkan fungsionalitas untuk menghasilkan laporan absensi.