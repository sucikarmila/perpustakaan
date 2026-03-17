
# 📚 Sistem Informasi Perpustakaan Digital - Laravel 11

[![Laravel Version](https://img.shields.io/badge/Laravel-11.x-red.svg)](https://laravel.com)
[![License](https://img.shields.io/badge/License-MIT-blue.svg)](LICENSE)

Aplikasi manajemen perpustakaan modern yang dirancang untuk mendigitalisasi seluruh ekosistem literasi, mulai dari pengelolaan katalog buku oleh petugas hingga interaksi peminjaman oleh anggota secara real-time.

---

## 🎯 Fitur Utama

### 🔐 Autentikasi & Multi-User
- **Role-Based Access**: Pemisahan hak akses yang ketat antara **Petugas (Admin)** dan **Anggota (Peminjam)**.
- **Secure Register**: Sistem pendaftaran anggota baru dengan validasi data yang aman.

### 📖 Manajemen Katalog & Inventaris
- **Data Master**: Kelola kategori, penulis, penerbit, hingga tahun terbit buku secara terpusat.
- **Monitoring Stok**: Pemantauan jumlah ketersediaan buku yang siap dipinjam secara otomatis.

### 🔄 Transaksi Digital
- **Smart Lending**: Pencatatan tanggal pinjam dan estimasi batas waktu pengembalian.
- **Konfirmasi Petugas**: Alur kerja validasi peminjaman oleh admin untuk keamanan aset.
- **Riwayat & Koleksi**: Anggota dapat melacak buku yang sedang dipinjam atau menyimpan buku favorit ke koleksi pribadi.

### 📊 Pelaporan & Audit
- **Laporan Transaksi**: Rekapitulasi data peminjaman dalam periode tertentu.
- **PDF Export**: Cetak laporan resmi dalam format PDF untuk kebutuhan administratif.

---

## 🗄️ Database Schema

```mermaid
graph TD
    user[Admin] -->|Melayani| peminjaman
    peminjam[User] -->|Melakukan| peminjaman
    buku[Buku] -->|Dipinjam| peminjaman
    kategoribuku[Kategori buku] -->|Mengelompokkan| buku
````

-----

## 🚀 Quick Start (Instalasi)

1.  **Clone & Install**

    ```bash
    git clone [https://github.com/sucikarmila/perpustakaan.git](https://github.com/sucikarmila/perpustakaan.git)
    cd perpustakaan
    composer install
    npm install && npm run build
    ```

2.  **Environment & Key**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

3.  **Database Setup**
    Konfigurasi database di file `.env`, lalu jalankan:

    ```bash
    php artisan migrate --seed
    php artisan storage:link
    ```

4.  **Run Application**

    ```bash
    php artisan serve
    ```

-----

## 🛠️ Troubleshooting & Debugging

Jika Anda menemui kendala saat menjalankan aplikasi, silakan ikuti langkah-langkah berikut:

### 1\. Masalah Izin Folder (Permissions)

Jika muncul error terkait penulisan file, jalankan perintah berikut:

```bash
chmod -R 775 storage bootstrap/cache
```

### 2\. Reset Database & Cache

Jika skema database tidak sinkron atau data tidak muncul:

```bash
# Hapus dan buat ulang tabel (Hati-hati: Data akan hilang!)
php artisan migrate:fresh --seed

# Bersihkan semua cache aplikasi
php artisan optimize:clear
```

### 3\. Debugging Mode

Untuk melihat detail error saat pengembangan, pastikan nilai berikut di file `.env`:

```env
APP_DEBUG=true
APP_ENV=local
```

### 4\. Masalah Gambar/Asset

Jika gambar atau cover buku tidak muncul, pastikan *symbolic link* sudah dibuat:

```bash
php artisan storage:link
```

-----

## 📸 Dokumentasi Antarmuka

### Halaman Petugas (Admin)

  - **Manajemen Katalog**: Kategori, Buku, dan Konfirmasi Peminjaman.
  - **Reporting**: Fitur cetak laporan PDF tersedia di menu Laporan.

### Halaman Anggota (Pengguna)

  - **Katalog Digital**: Jelajahi daftar buku dan simpan ke Koleksi.
  - **Track Record**: Pantau status peminjaman dan riwayat pengembalian.

-----


_**DOCUMENTATION**_

FITUR-FITUR

LOGIN
<img width="1862" height="847" alt="image" src="https://github.com/user-attachments/assets/3f76acc5-26eb-40b0-9390-e25283b9a46a" />
register
<img width="1851" height="852" alt="image" src="https://github.com/user-attachments/assets/ea81ff3b-2ce6-4228-967a-417faac589ad" />

ADMIN/PETUGAS

A. DASHBOARD ADMIN
<img width="1106" height="888" alt="image" src="https://github.com/user-attachments/assets/c42082fa-18c8-48c6-bc0b-da16131e3bee" />
B. KATEGORI
<img width="1090" height="345" alt="image" src="https://github.com/user-attachments/assets/daeede99-d2d6-4e7d-9953-89bd5a70a64c" />
C. BUKU
<img width="1094" height="457" alt="image" src="https://github.com/user-attachments/assets/08540d53-3825-4cb3-8bd8-23bd1120028c" />
D. KONFIRMASI
<img width="1083" height="373" alt="image" src="https://github.com/user-attachments/assets/a49d14cd-f637-41e8-adbd-59f19b6be4be" />
E. LAPORAN
<img width="1063" height="617" alt="image" src="https://github.com/user-attachments/assets/1099aaa9-0e96-4122-a654-19261c70a13c" />
F. PENGGUNA
<img width="1077" height="439" alt="image" src="https://github.com/user-attachments/assets/3f1b5b0c-f1a8-4032-ab18-222c4b845e40" />

PENGGUNA

A. DASHBOARD PENGGUNA
<img width="1103" height="674" alt="image" src="https://github.com/user-attachments/assets/089052fe-b4eb-4d54-9318-55ec7af0ec82" />
B. DAFTAR BUKU
<img width="1089" height="676" alt="image" src="https://github.com/user-attachments/assets/e9f40a10-e0a8-4963-9fd6-a6d9f41ff8ad" />
C. KOLEKSI BUKU
<img width="1099" height="387" alt="image" src="https://github.com/user-attachments/assets/fbb47e1d-a619-4c99-965e-7a84ced23b22" />
D. RIWAYAT PEMINJAMAN PENGGUNA
<img width="1087" height="481" alt="image" src="https://github.com/user-attachments/assets/bd9dbd0f-705c-4b26-ba4e-7cf5329f46cf" />
