@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-9 col-xl-8">
            <div class="card border-0 shadow-lg animate__animated animate__zoomIn" style="border-radius: 25px; overflow: hidden;">
                <div class="row g-0">
                    
                    <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4 p-lg-5">
                        <div class="text-center">
                            @if($buku->Gambar)
                                <img src="{{ asset('storage/'.$buku->Gambar) }}" class="img-fluid rounded-4 shadow-lg mb-3 book-preview-img" alt="{{ $buku->Judul }}">
                            @else
                                <div class="bg-white rounded-4 shadow-sm d-flex align-items-center justify-content-center mb-3" style="width: 200px; height: 300px;">
                                    <i class="fas fa-book fa-4x text-light"></i>
                                </div>
                            @endif
                            <h5 class="fw-bold text-dark mb-1 px-2">{{ $buku->Judul }}</h5>
                            <p class="text-muted small px-2">{{ $buku->Penulis }}</p>
                            <span class="badge bg-soft-primary text-primary rounded-pill px-3">{{ $buku->kategori->NamaKategori ?? 'Umum' }}</span>
                        </div>
                    </div>

                    <div class="col-md-7 p-4 p-lg-5">
                        <div class="mb-4">
                            <h3 class="fw-bold text-primary mb-1">Konfirmasi Peminjaman</h3>
                            <p class="text-muted small">Satu langkah lagi untuk memulai petualangan membacamu.</p>
                        </div>

                        <form action="{{ route('pinjam.proses') }}" method="POST">
                            @csrf
                            <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
                            
                            <div class="rule-box p-3 rounded-4 mb-4">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="fas fa-info-circle text-primary me-2"></i>
                                    <span class="fw-bold small text-dark">Informasi Peminjaman</span>
                                </div>
                                <div class="row g-2">
                                    <div class="col-6 small text-muted">Denda Keterlambatan:</div>
                                    <div class="col-6 small fw-bold text-danger text-end">Rp 1.000 / hari</div>
                                    <div class="col-6 small text-muted">Status Buku:</div>
                                    <div class="col-6 small fw-bold text-success text-end">Tersedia</div>
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="form-label fw-bold text-dark small">Pilih Durasi Peminjaman</label>
                                <div class="input-group input-group-lg custom-select-wrapper">
                                    <span class="input-group-text bg-white border-end-0 rounded-start-4"><i class="fas fa-calendar-alt text-primary"></i></span>
                                    <select name="lama_pinjam" id="lama_pinjam" class="form-select border-start-0 rounded-end-4 fw-bold text-dark fs-6" required>
                                        <option value="3">3 Hari (Sangat Singkat)</option>
                                        <option value="7" selected>7 Hari (Normal - Rekomendasi)</option>
                                        <option value="14">14 Hari (Premium + Biaya Rp 5.000)</option>
                                    </select>
                                </div>
                            </div>

                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg rounded-pill shadow-sm fw-bold py-3 animate-btn">
                                    <i class="fas fa-check-circle me-2"></i>Selesaikan Peminjaman
                                </button>
                                <a href="/pinjam-buku" class="btn btn-link text-muted text-decoration-none small">
                                    <i class="fas fa-arrow-left me-1"></i> Kembali ke Katalog
                                </a>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <p class="text-center text-muted mt-4 small">
                Buku yang dipinjam sepenuhnya menjadi tanggung jawab Anda. <br>
                Harap mengembalikan tepat waktu untuk menghindari denda sistem.
            </p>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #e7f0ff; }
    
    .book-preview-img {
        max-width: 200px;
        transform: rotate(-3deg);
        transition: transform 0.3s ease;
    }
    
    .book-preview-img:hover {
        transform: rotate(0deg) scale(1.05);
    }

    .rule-box {
        background-color: #f8fbff;
        border: 1px dashed #cfe2ff;
    }

    .form-select {
        cursor: pointer;
        transition: all 0.2s;
    }
    
    .form-select:focus {
        border-color: #0d6efd;
        box-shadow: none;
    }

    .rounded-4 { border-radius: 1.25rem !important; }
    .rounded-start-4 { border-top-left-radius: 1.25rem !important; border-bottom-left-radius: 1.25rem !important; }
    .rounded-end-4 { border-top-right-radius: 1.25rem !important; border-bottom-right-radius: 1.25rem !important; }

    .animate-btn {
        transition: all 0.3s;
    }
    .animate-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3) !important;
        background-color: #0b5ed7;
    }

    .font-syne { font-family: 'Syne', sans-serif; }
</style>
@endsection