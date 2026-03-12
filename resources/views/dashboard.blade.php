@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col-12">
            <div class="hero-glass p-5 animate__animated animate__fadeIn">
                <div class="row align-items-center">
                    <div class="col-lg-8">
                        <span class="badge rounded-pill bg-primary px-3 py-2 mb-3 animate__animated animate__fadeInDown">
                            <i class="fas fa-sparkles me-2"></i>Sistem Manajemen Perpustakaan
                        </span>
                        <h1 class="display-4 fw-800 mb-2 font-syne animate__animated animate__fadeInLeft">
                            Selamat Datang, <span class="text-primary">{{ Auth::user()->NamaLengkap }}</span>!
                        </h1>
                        <p class="lead text-white-50 mb-4 animate__animated animate__fadeInLeft" style="max-width: 600px;">
                            Jelajahi ribuan koleksi buku digital atau kelola operasional perpustakaan dengan fitur cerdas kami.
                        </p>
                        
                        <div class="d-flex gap-3 animate__animated animate__fadeInUp">
                            <div class="role-badge">
                                <i class="fas fa-user-shield me-2"></i>
                                <span>Akses: <strong>{{ strtoupper(Auth::user()->Role) }}</strong></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 d-none d-lg-block text-center">
                        <div class="floating-icon">
                            <i class="fas fa-book-reader fa-8x text-primary opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row g-4 animate__animated animate__fadeInUp">
    @if(Auth::user()->Role == 'admin' || Auth::user()->Role == 'petugas')
        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-primary-gradient mb-3">
                    <i class="fas fa-tags"></i> </div>
                <h4>Kelola Kategori</h4>
                <p class="text-white-50 small">Atur klasifikasi buku berdasarkan genre, topik, atau seri.</p>
                <a href="/kategori" class="btn btn-sm btn-outline-primary rounded-pill px-4">Buka Kategori</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-primary-gradient mb-3">
                    <i class="fas fa-book"></i> </div>
                <h4>Kelola Buku</h4>
                <p class="text-white-50 small">Manajemen inventaris judul buku, stok, dan detail informasi buku.</p>
                <a href="/buku" class="btn btn-sm btn-outline-primary rounded-pill px-4">Buka Buku</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-info-gradient mb-3">
                    <i class="fas fa-chart-line"></i> </div>
                <h4>Laporan Peminjaman</h4>
                <p class="text-white-50 small">Pantau statistik peminjaman dan performa sirkulasi secara real-time.</p>
                <a href="/laporan" class="btn btn-sm btn-outline-info rounded-pill px-4">Lihat Laporan</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-primary-gradient mb-3">
                    <i class="fas fa-users-cog"></i> </div>
                <h4>Kelola Pengguna</h4>
                <p class="text-white-50 small">Atur hak akses anggota, petugas, dan manajemen akun sistem.</p>
                <a href="/user-management" class="btn btn-sm btn-outline-primary rounded-pill px-4">Lihat Pengguna</a>
            </div>
        </div>
    @else
        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-success-gradient mb-3">
                    <i class="fas fa-search-plus"></i> </div>
                <h4>Cari Buku</h4>
                <p class="text-white-50 small">Temukan bacaan favoritmu dari berbagai kategori koleksi kami.</p>
                <a href="/pinjam-buku" class="btn btn-sm btn-outline-success rounded-pill px-4">Mulai Pinjam</a>
            </div>
        </div>

        <div class="col-md-4">
            <div class="stat-card p-4">
                <div class="icon-box bg-warning-gradient mb-3">
                    <i class="fas fa-history"></i> </div>
                <h4>Riwayat Peminjaman</h4>
                <p class="text-white-50 small">Cek daftar buku yang sedang dipinjam atau yang sudah dikembalikan.</p>
                <a href="/riwayat" class="btn btn-sm btn-outline-warning rounded-pill px-4">Cek Riwayat</a>
            </div>
        </div>
    @endif
</div>
</div>

<style>
    .font-syne { font-family: 'Syne', sans-serif; }
    .fw-800 { font-weight: 800; }

    /* Hero Glass Effect */
    .hero-glass {
        background: linear-gradient(135deg, rgba(255,255,255,0.05) 0%, rgba(255,255,255,0) 100%);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.1);
        border-radius: 30px;
        position: relative;
        overflow: hidden;
    }

    .hero-glass::after {
        content: '';
        position: absolute;
        top: -50%; right: -10%;
        width: 300px; height: 300px;
        background: var(--primary-blue);
        filter: blur(120px);
        opacity: 0.2;
        z-index: -1;
    }

    /* Role Badge */
    .role-badge {
        background: rgba(13, 110, 253, 0.15);
        color: #0d6efd;
        padding: 10px 20px;
        border-radius: 15px;
        border: 1px solid rgba(13, 110, 253, 0.3);
        display: inline-flex;
        align-items: center;
    }

    /* Stat Cards */
    .stat-card {
        background: rgba(255,255,255,0.03);
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255,255,255,0.08);
        border-radius: 24px;
        transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        height: 100%;
    }

    .stat-card:hover {
        transform: translateY(-10px);
        background: rgba(255,255,255,0.06);
        border-color: rgba(13, 110, 253, 0.4);
        box-shadow: 0 20px 40px rgba(0,0,0,0.3);
    }

    /* Icon Boxes */
    .icon-box {
        width: 50px; height: 50px;
        display: flex; align-items: center;
        justify-content: center;
        border-radius: 15px;
        font-size: 1.5rem;
        color: white;
    }

    .bg-primary-gradient { background: linear-gradient(45deg, #0d6efd, #00d2ff); }
    .bg-info-gradient { background: linear-gradient(45deg, #0dcaf0, #00f2fe); }
    .bg-success-gradient { background: linear-gradient(45deg, #198754, #20c997); }
    .bg-warning-gradient { background: linear-gradient(45deg, #ffc107, #ff9800); }

    /* Floating Animation */
    .floating-icon {
        animation: floating 3s ease-in-out infinite;
    }

    @keyframes floating {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-20px); }
    }
</style>
@endsection