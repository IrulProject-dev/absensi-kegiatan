<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dokumentasi Laravel</title>
    <!-- Tailwind CSS CDN untuk styling yang cepat dan responsif -->
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Gaya dasar untuk font dan warna latar belakang */
        body {
            font-family: 'Inter', sans-serif; /* Menggunakan font Inter yang bersih */
            background-color: #f8fafc; /* Latar belakang abu-abu terang */
            color: #334155; /* Warna teks gelap */
            line-height: 1.6; /* Ketinggian baris untuk keterbacaan */
        }
        /* Gaya untuk blok kode (preformatted text) */
        pre {
            background-color: #1e293b; /* Latar belakang biru gelap untuk kode */
            color: #e2e8f0; /* Warna teks terang untuk kode */
            padding: 1rem;
            border-radius: 0.5rem; /* Sudut membulat */
            overflow-x: auto; /* Memungkinkan scroll horizontal jika kode terlalu panjang */
            position: relative; /* Diperlukan untuk penempatan tombol salin */
        }
        /* Gaya untuk kode inline */
        code {
            font-family: 'Roboto Mono', monospace; /* Font monospace untuk kode */
            background-color: #e2e8f0; /* Latar belakang abu-abu terang untuk kode inline */
            padding: 0.2em 0.4em;
            border-radius: 0.25rem;
            color: #334155;
        }
        /* Gaya untuk tombol salin di samping blok kode (tetap ada jika nanti diperlukan) */
        .copy-button {
            position: absolute;
            top: 0.5rem;
            right: 0.5rem;
            background-color: #3b82f6; /* Warna biru */
            color: white;
            padding: 0.3rem 0.6rem;
            border-radius: 0.375rem; /* Sudut membulat */
            font-size: 0.75rem; /* Ukuran font kecil */
            cursor: pointer;
            border: none;
            transition: background-color 0.2s; /* Transisi halus saat hover */
        }
        .copy-button:hover {
            background-color: #2563eb; /* Biru lebih gelap saat hover */
        }
    </style>
</head>
<body class="p-4 sm:p-8">
    <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-6 sm:p-10 lg:p-12">
        <!-- Header Dokumen - Diperbarui dengan Logo dan Badge Laravel -->
        <header class="pb-6 mb-6 border-b border-slate-200 text-center">
            <p class="mb-4">
                <a href="https://laravel.com" target="_blank" class="inline-block">
                    <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo" class="mx-auto">
                </a>
            </p>
            <!-- Bagian Badge/Ikon - Diperbarui dengan badge Laravel -->
            <div class="mt-4 flex flex-wrap gap-2 justify-center">
                <a href="https://github.com/laravel/framework/actions" target="_blank" rel="noopener noreferrer"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status" class="h-6"></a>
                <a href="https://packagist.org/packages/laravel/framework" target="_blank" rel="noopener noreferrer"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads" class="h-6"></a>
                <a href="https://packagist.org/packages/laravel/framework" target="_blank" rel="noopener noreferrer"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version" class="h-6"></a>
                <a href="https://packagist.org/packages/laravel/framework" target="_blank" rel="noopener noreferrer"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License" class="h-6"></a>
            </div>
        </header>

        <!-- Daftar Isi (Table of Contents) - Diperbarui untuk Laravel -->
        <nav class="mb-8">
            <h2 class="text-2xl font-semibold text-slate-700 mb-4">Daftar Isi</h2>
            <ul class="list-disc list-inside text-slate-600">
                <li class="mb-1"><a href="#tentang-laravel" class="text-blue-600 hover:underline">Tentang Laravel</a></li>
                <li class="mb-1"><a href="#belajar-laravel" class="text-blue-600 hover:underline">Belajar Laravel</a></li>
                <li class="mb-1"><a href="#sponsor-laravel" class="text-blue-600 hover:underline">Sponsor Laravel</a></li>
                <li class="mb-1"><a href="#kontribusi" class="text-blue-600 hover:underline">Kontribusi</a></li>
                <li class="mb-1"><a href="#kode-etik" class="text-blue-600 hover:underline">Kode Etik</a></li>
                <li class="mb-1"><a href="#kerentanan-keamanan" class="text-blue-600 hover:underline">Kerentanan Keamanan</a></li>
                <li class="mb-1"><a href="#lisensi" class="text-blue-600 hover:underline">Lisensi</a></li>
            </ul>
        </nav>

        <!-- Bagian Tentang Laravel -->
        <section id="tentang-laravel" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Tentang Laravel</h2>
            <p class="text-slate-600 mb-4">Laravel adalah kerangka kerja aplikasi web dengan sintaksis ekspresif dan elegan. Kami percaya pengembangan harus menjadi pengalaman yang menyenangkan dan kreatif agar benar-benar memuaskan. Laravel menghilangkan kesulitan dalam pengembangan dengan mempermudah tugas-tugas umum yang digunakan dalam banyak proyek web, seperti:</p>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
                <li><a href="https://laravel.com/docs/routing" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Mesin routing yang sederhana dan cepat</a>.</li>
                <li><a href="https://laravel.com/docs/container" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Kontainer injeksi dependensi yang kuat</a>.</li>
                <li>Berbagai back-end untuk penyimpanan <a href="https://laravel.com/docs/session" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">sesi</a> dan <a href="https://laravel.com/docs/cache" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">cache</a>.</li>
                <li><a href="https://laravel.com/docs/eloquent" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">ORM basis data yang ekspresif dan intuitif</a>.</li>
                <li><a href="https://laravel.com/docs/migrations" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Migrasi skema yang agnostik basis data</a>.</li>
                <li><a href="https://laravel.com/docs/queues" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Pemrosesan tugas latar belakang yang tangguh</a>.</li>
                <li><a href="https://laravel.com/docs/broadcasting" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Penyiaran acara waktu nyata</a>.</li>
            </ul>
            <p class="text-slate-600 mt-4">Laravel mudah diakses, kuat, dan menyediakan alat yang diperlukan untuk aplikasi yang besar dan tangguh.</p>
        </section>

        <!-- Bagian Belajar Laravel -->
        <section id="belajar-laravel" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Belajar Laravel</h2>
            <p class="text-slate-600 mb-4">Laravel memiliki <a href="https://laravel.com/docs" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">dokumentasi</a> dan perpustakaan tutorial video terlengkap dan menyeluruh dari semua kerangka kerja aplikasi web modern, membuatnya sangat mudah untuk memulai dengan kerangka kerja ini.</p>
            <p class="text-slate-600 mb-4">Anda juga bisa mencoba <a href="https://bootcamp.laravel.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Laravel Bootcamp</a>, di mana Anda akan dipandu dalam membangun aplikasi Laravel modern dari awal.</p>
            <p class="text-slate-600">Jika Anda tidak suka membaca, <a href="https://laracasts.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Laracasts</a> dapat membantu. Laracasts berisi ribuan tutorial video tentang berbagai topik termasuk Laravel, PHP modern, pengujian unit, dan JavaScript. Tingkatkan keterampilan Anda dengan mempelajari perpustakaan video komprehensif kami.</p>
        </section>

        <!-- Bagian Sponsor Laravel -->
        <section id="sponsor-laravel" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Sponsor Laravel</h2>
            <p class="text-slate-600 mb-4">Kami ingin mengucapkan terima kasih kepada para sponsor berikut karena telah mendanai pengembangan Laravel. Jika Anda tertarik untuk menjadi sponsor, silakan kunjungi <a href="https://partners.laravel.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">program Mitra Laravel</a>.</p>
            <h3 class="text-2xl font-semibold text-slate-700 mb-3">Mitra Premium</h3>
            <ul class="list-disc list-inside text-slate-600 space-y-2">
                <li><a href="https://vehikl.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Vehikl</strong></a></li>
                <li><a href="https://tighten.co" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Tighten Co.</strong></a></li>
                <li><a href="https://kirschbaumdevelopment.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Kirschbaum Development Group</strong></a></li>
                <li><a href="https://64robots.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>64 Robots</strong></a></li>
                <li><a href="https://www.curotec.com/services/technologies/laravel" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Curotec</strong></a></li>
                <li><a href="https://devsquad.com/hire-laravel-developers" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>DevSquad</strong></a></li>
                <li><a href="https://redberry.international/laravel-development" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Redberry</strong></a></li>
                <li><a href="https://activelogic.com" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline"><strong>Active Logic</strong></a></li>
            </ul>
        </section>

        <!-- Bagian Kontribusi -->
        <section id="kontribusi" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Kontribusi</h2>
            <p class="text-slate-600">Terima kasih telah mempertimbangkan untuk berkontribusi pada kerangka kerja Laravel! Panduan kontribusi dapat ditemukan di <a href="https://laravel.com/docs/contributions" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">dokumentasi Laravel</a>.</p>
        </section>

        <!-- Bagian Kode Etik -->
        <section id="kode-etik" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Kode Etik</h2>
            <p class="text-slate-600">Untuk memastikan bahwa komunitas Laravel ramah bagi semua, harap tinjau dan patuhi <a href="https://laravel.com/docs/contributions#code-of-conduct" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">Kode Etik</a>.</p>
        </section>

        <!-- Bagian Kerentanan Keamanan -->
        <section id="kerentanan-keamanan" class="mb-8 pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Kerentanan Keamanan</h2>
            <p class="text-slate-600">Jika Anda menemukan kerentanan keamanan di dalam Laravel, silakan kirim email ke Taylor Otwell melalui <a href="mailto:taylor@laravel.com" class="text-blue-600 hover:underline">taylor@laravel.com</a>. Semua kerentanan keamanan akan segera ditangani.</p>
        </section>

        <!-- Bagian Lisensi -->
        <section id="lisensi" class="pt-4">
            <h2 class="text-3xl font-bold text-slate-700 mb-4">Lisensi</h2>
            <p class="text-slate-600">Kerangka kerja Laravel adalah perangkat lunak open-source yang dilisensikan di bawah <a href="https://opensource.org/licenses/MIT" target="_blank" rel="noopener noreferrer" class="text-blue-600 hover:underline">lisensi MIT</a>.</p>
        </section>
    </div>

    <script>
        // JavaScript untuk smooth scrolling ke bagian yang sesuai
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault(); // Mencegah perilaku default tautan

                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth' // Gulir dengan animasi halus
                });
            });
        });

        // Fungsi copyCode tetap dipertahankan meskipun tidak ada tombol salin yang langsung digunakan saat ini
        function copyCode(id) {
            const codeElement = document.getElementById(id);
            if (codeElement) {
                const textToCopy = codeElement.innerText;
                try {
                    const textarea = document.createElement('textarea');
                    textarea.value = textToCopy;
                    document.body.appendChild(textarea);
                    textarea.select();
                    document.execCommand('copy');
                    document.body.removeChild(textarea);

                    const button = codeElement.nextElementSibling;
                    if (button && button.classList.contains('copy-button')) {
                        const originalText = button.innerText;
                        button.innerText = 'Disalin!';
                        setTimeout(() => {
                            button.innerText = originalText;
                        }, 2000);
                    }
                } catch (err) {
                    console.error('Gagal menyalin teks: ', err);
                }
            }
        }
    </script>
</body>
</html>
