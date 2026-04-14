# LSP-eTicketing

<p align="center">
  <img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo">
</p>

## Deskripsi Proyek

LSP E-Ticketing adalah platform pemesanan tiket modern yang dirancang khusus untuk Lembaga Sertifikasi Profesi (LSP). Aplikasi ini dibangun menggunakan framework **Laravel** dan **Tailwind CSS**, menampilkan desain "Office Web" bertema merah yang profesional, bersih, dan konsisten (menggunakan tipografi Poppins dan elemen *glassmorphism*).

Aplikasi ini mendukung alur kerja manajemen pemesanan secara penuh, mulai dari pembelian tiket oleh pelanggan, pengunggahan bukti pembayaran, hingga persetujuan manual oleh admin.

## Fitur Utama

- **Role-Based Access Control (RBAC)**
  Aplikasi memiliki dua level akses utama:
  - **Pelanggan (Customer):** Dapat melihat jadwal e-ticketing, melakukan pemesanan (booking), mengunggah bukti pembayaran, melihat riwayat pemesanan, serta mencetak e-ticket.
  - **Administrator:** Memiliki akses ke *dashboard* *back-office* untuk mengelola jadwal (CRUD), memverifikasi dan menyetujui transaksi pemesanan (mengubah status *Pending* ke *Lunas*), serta melihat bukti pembayaran.
  
- **Alur Kerja Pembayaran Berbasis Persetujuan (Approval System)**
  Setiap pemesanan akan berstatus *Pending* dan memerlukan tinjauan administratif terhadap bukti pembayaran sebelum tiket dinyatakan valid dan siap dicetak.

- **Antarmuka Pengguna (UI) Modern & Responsif**
  Desain *frontend* aplikasi sepenuhnya mengadopsi standar modern dengan pendekatan estetika "*Office Web*". Mendukung fitur animatif interaktif, palet warna elegan, dan fungsionalitas mulus di berbagai perangkat.

## Teknologi yang Digunakan

- **Backend:** [Laravel](https://laravel.com/) (PHP)
- **Frontend:** HTML, Blade Templates, Vanilla JS
- **Styling:** [Tailwind CSS v4](https://tailwindcss.com/) & Vanilla CSS *custom utilities*
- **Bundler:** Vite
- **Database:** MySQL / SQLite / PostgreSQL (sesuai konfigurasi `.env`)

---

## Panduan Instalasi & Menjalankan Aplikasi Lokal

Ikuti langkah-langkah di bawah ini untuk menginstal dan menjalankan aplikasi di komputer lokal (Local Development).

### Persyaratan Sistem
- PHP >= 8.3
- Composer
- Node.js & npm (untuk Vite dan Tailwind CSS)
- Database Server (seperti MySQL, SQLite, dll.)

### Langkah Instalasi

1. **Kloning Repositori (Jika belum)**
   ```bash
   git clone https://github.com/username/lsp-eticketing.git
   cd lsp-eticketing
   ```

2. **Instalasi Dependensi PHP**
   Jalankan perintah berikut untuk menginstal semua *library* backend:
   ```bash
   composer install
   ```

3. **Instalasi Dependensi Frontend**
   Jalankan npm untuk menginstal library Javascript dan Tailwind CSS:
   ```bash
   npm install
   ```

4. **Konfigurasi Environment Variable (.env)**
   Salin file konfigurasi bawaan dan sesuaikan kredensial database Anda (DB_DATABASE, DB_USERNAME, DB_PASSWORD).
   ```bash
   cp .env.example .env
   ```

5. **Generate Application Key**
   ```bash
   php artisan key:generate
   ```

6. **Jalankan Migrasi Database (dan Seeder)**
   Hal ini untuk membuat tabel-tabel penting dalam database. Jika ada seeder (data *dummy*), gunakan flag `--seed`.
   ```bash
   php artisan migrate --seed
   ```

7. **Kompilasi Aset Frontend (Tailwind CSS/Vite)**
   Anda perlu mem-build aset frontend saat produksi, atau menjalankannya dalam mode *watch* saat pengembangan.
   ```bash
   npm run build
   # ATAU untuk development otomatis
   # npm run dev
   ```

8. **Nyalakan Development Server Laravel**
   ```bash
   php artisan serve
   ```
   Aplikasi Anda kini bisa diakses melalui web browser pada: `http://localhost:8000`

## Kontribusi

Bagi pihak/developer yang ingin berkontribusi dalam perbaikan bug (_bug fixes_), pembaruan (_updates_), maupun perancangan fitur baru, Anda dapat melakukan _pull requests_ dengan mengacu pada standar koding Laravel dan memastikan integrasi estetika antarmuka tidak rusak.

## Lisensi

[MIT License](https://opensource.org/licenses/MIT). Silahkan merujuk pada file `LICENSE` (jika tersedia) untuk ketentuan lebih detail penggunaan *framework* yang diusung.
