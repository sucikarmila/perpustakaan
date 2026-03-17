
# 📚 Sistem Informasi Perpustakaan Digital - Laravel

Aplikasi manajemen perpustakaan modern berbasis **Laravel** yang dirancang untuk mempermudah pengelolaan data buku, keanggotaan, serta proses peminjaman dan pengembalian buku secara digital.

---

## 🎯 Fitur Utama

### 🔐 Autentikasi & Multi-User
- **Sistem Login**: Akses berbeda untuk Petugas/Admin dan Anggota.
- **Manajemen User**: Pengelolaan data pengguna dan hak akses sistem.

### 📖 Manajemen Katalog Buku
- **Data Buku**: Input judul, penulis, penerbit, tahun terbit, dan kategori.
- **Kategori Buku**: Pengelompokan buku berdasarkan genre atau topik.
- **Stok Buku**: Pemantauan jumlah buku yang tersedia untuk dipinjam.

### 🔄 Transaksi Peminjaman
- **Peminjaman**: Pencatatan tanggal pinjam dan batas waktu kembali.
- **Pengembalian**: Proses retur buku dengan pengecekan keterlambatan.
- **Riwayat**: Catatan lengkap aktivitas peminjaman setiap anggota.

### 📊 Laporan & Cetak
- **Laporan Transaksi**: Rekapitulasi data peminjaman dalam periode tertentu.
- **Ekspor Data**: Cetak laporan dalam format PDF .

---

## 🗄️ Database Schema

Situs ini menggunakan relasi database untuk menghubungkan buku dengan transaksi peminjaman:

```mermaid
graph TD
    user -->|Melayani| peminjaman
    buku -->|Dipinjam| peminjaman
    kategoribuku -->|Mengelompokkan| buku
    peminjam -->|Melakukan| peminjaman
````

-----

## 🚀 Quick Start (Instalasi)

Ikuti langkah berikut untuk menjalankan proyek di perangkat lokal Anda:

1.  **Clone Repository**

    ```bash
    git clone [https://github.com/sucikarmila/perpustakaan.git](https://github.com/sucikarmila/perpustakaan.git)
    cd perpustakaan
    ```

2.  **Install Dependencies**

    ```bash
    composer install
    npm install && npm run build
    ```

3.  **Setup Environment**

    ```bash
    cp .env.example .env
    php artisan key:generate
    ```

4.  **Konfigurasi Database**
    Sesuaikan `.env` dengan database lokal Anda:

    ```env
    DB_DATABASE=perpustakaan
    DB_USERNAME=root
    DB_PASSWORD=
    ```

5.  **Migrasi & Seeding**

    ```bash
    php artisan migrate --seed
    ```

6.  **Jalankan Aplikasi**

    ```bash
    php artisan serve
    ```

    Akses di: `http://localhost:8000`

-----

## 🎓 Spesifikasi Hak Akses

| Fitur | Petugas (Admin) | Anggota |
| :--- | :---: | :---: |
| Kelola Data Kategori Buku | ✓ | - |
| Kelola Data Buku | ✓ | - |
| Kelola Anggota | ✓ | - |
| Input Peminjaman | - | ✓ |
| Lihat Riwayat Pinjam | ✓ | ✓ |
| Cari Katalog Buku | ✓ | ✓ |


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
