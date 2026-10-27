# Kopikuy CMS PHP

Demo katalog Kopikuy dengan administrasi produk PHP dan MySQL. Berbeda dari kopikuyweb versi statis.

## Yang tersedia

- Daftar produk berdasarkan kategori.
- Form tambah, edit, dan hapus produk.
- Unggah foto produk serta halaman produk berbasis database.

## Menjalankan demo

PHP 8 dengan ekstensi mysqli dan MySQL/MariaDB. Fitur unggah memakai fasilitas file upload PHP. Proyek ini tidak membutuhkan Composer.

1. Buat database demo MySQL/MariaDB dengan charset utf8mb4.
2. Impor `database/schema.sql` melalui Adminer/phpMyAdmin atau klien MySQL. Skema tidak berisi akun atau data operasional.
3. Salin `.env.example` menjadi `.env`, lalu isi DB_NAME, DB_USER, DB_PASSWORD, dan alamat database lokal.
4. Dari root proyek, jalankan `php -S 127.0.0.1:8000` dan buka `http://127.0.0.1:8000`. Server bawaan PHP hanya untuk latihan lokal.

## Struktur yang perlu dibaca

`config.php` atau `db.php` membuka koneksi database; `bootstrap_env.php` membaca konfigurasi lokal; `database/schema.sql` mendefinisikan tabel kosong. Halaman PHP berisi alur aplikasi dan HTML yang masih mengikuti struktur legacy.

## Batas implementasi

- Sumber utama dipilih dari kopikuyweb-main karena memiliki pengelompokan kategori, unggah foto lokal, produk.php, dan main.js. Varian URL tetap berada di folder sumber asli dan tidak digabungkan.
- Halaman CRUD belum memiliki login admin; query legacy masih menginterpolasi input dan penghapusan memakai GET. Jangan mengekspos prototype ini ke internet.
- Unggahan dan snapshot produk lokal tidak disertakan. data.json berisi kategori kosong agar katalog HTML dapat dimuat tanpa data pribadi; produk.php membaca database. Katalog HTML dan CRUD database belum disinkronkan otomatis.
- Tidak ada metadata Git atau lisensi proyek yang dapat dipastikan dari salinan lokal. Aset UI pihak ketiga tetap mengikuti lisensinya.

## Pemeriksaan publikasi

- PHP lint: 7/7 berkas PHP non-Blade lolos menggunakan PHP 8.1.12.
- Salinan publik tidak menyertakan .env aktual, dependency Composer/Node, log, database dump, arsip, sesi, atau unggahan lokal.
- Tes framework, koneksi database, pengoperasian UI, build aset, dan API eksternal belum dijalankan pada salinan ini. Lint hanya memeriksa sintaks; tidak membuktikan seluruh fitur berfungsi.

## Asal source dan lisensi

Disiapkan dari salinan lokal kopikuy-cms-php/kopikuyweb-main. Tidak ada URL upstream yang dipastikan dari metadata Git untuk proyek ini. Jangan menganggap lisensi framework atau aset otomatis melisensikan seluruh kode proyek.

Aset UI statis yang dirujuk aplikasi tetap disertakan beserta lisensi yang tersedia. Konten merek dan gambar mengikuti hak pemilik aslinya. Perubahan untuk publikasi ini meliputi dokumentasi, pemisahan konfigurasi lokal, skema demo bila diperlukan, dan koreksi terbatas yang dicatat pada persiapan proyek.
