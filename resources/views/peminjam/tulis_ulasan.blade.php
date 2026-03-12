@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
            <div class="card shadow-lg border-0 animate__animated animate__fadeIn" style="border-radius: 25px; overflow: hidden;">
                
                <div class="card-header bg-soft-primary border-0 pt-5 pb-2 text-center">
                    <div class="mb-3">
                        <div class="icon-circle bg-white text-primary mx-auto shadow-sm" style="width: 80px; height: 80px; display: flex; align-items: center; justify-content: center; border-radius: 50%;">
                            <i class="fas fa-star fa-2x"></i>
                        </div>
                    </div>
                    <h5 class="fw-bold text-dark px-3 mb-1">Berikan Ulasan Anda</h5>
                    <p class="text-primary fw-semibold small mb-3">{{ $buku->Judul }}</p>
                </div>

                <div class="card-body p-4 p-lg-5 pt-2">
                    <form action="{{ route('ulasan.simpan') }}" method="POST">
                        @csrf
                        <input type="hidden" name="BukuID" value="{{ $buku->BukuID }}">
                        
                        {{-- Star Rating --}}
                        <div class="mb-4 text-center">
                            <label class="d-block fw-bold text-muted small mb-3 text-uppercase" style="letter-spacing: 1.5px;">Rating Anda</label>
                            <div class="star-rating">
                                <input type="radio" id="star5" name="Rating" value="5" required /><label for="star5" title="Sangat Bagus"></label>
                                <input type="radio" id="star4" name="Rating" value="4" /><label for="star4" title="Bagus"></label>
                                <input type="radio" id="star3" name="Rating" value="3" /><label for="star3" title="Cukup"></label>
                                <input type="radio" id="star2" name="Rating" value="2" /><label for="star2" title="Kurang"></label>
                                <input type="radio" id="star1" name="Rating" value="1" /><label for="star1" title="Buruk"></label>
                            </div>
                        </div>

                        {{-- Textarea Ulasan --}}
                        <div class="mb-4">
                            <label class="form-label fw-bold text-primary small">Ceritakan Pengalaman Membaca</label>
                            <textarea name="Ulasan" class="form-control rounded-4 p-3 border-primary-subtle bg-light shadow-sm" 
                                      rows="4" placeholder="Tulis ulasan Anda di sini..." required style="resize: none;"></textarea>
                        </div>

                        {{-- Tombol Aksi --}}
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow bg-primary-gradient border-0">
                                <i class="fas fa-paper-plane me-2"></i>Kirim Ulasan
                            </button>
                            <a href="{{ route('riwayat') }}" class="btn btn-link text-muted text-decoration-none small mt-2">
                                <i class="fas fa-arrow-left me-1"></i> Kembali ke Riwayat
                            </a>
                        </div>
                    </form>
                </div>
            </div>

            <div class="text-center mt-4">
                <div class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill small">
                    <i class="fas fa-info-circle me-1"></i> Ulasan Anda membantu pembaca lain memilih buku terbaik.
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .bg-soft-primary { background-color: #f0f7ff; }
    
    .bg-primary-gradient { 
        background: linear-gradient(135deg, #0d6efd 0%, #0095ff 100%) !important; 
        transition: 0.3s;
    }
    .bg-primary-gradient:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 20px rgba(13, 110, 253, 0.3) !important;
    }

    .rounded-4 { border-radius: 1.2rem !important; }

    .star-rating {
        display: flex;
        flex-direction: row-reverse;
        justify-content: center;
    }

    .star-rating input { display: none; }

    .star-rating label {
        font-size: 2.8rem;
        color: #d1d9e6; 
        cursor: pointer;
        transition: all 0.2s ease-in-out;
        padding: 0 5px;
    }

    .star-rating label:before { content: "\2605"; } 

    .star-rating input:checked ~ label,
    .star-rating label:hover,
    .star-rating label:hover ~ label {
        color: #ffc107; 
        text-shadow: 0 0 15px rgba(255, 193, 7, 0.5);
        transform: scale(1.2);
    }

    .star-rating label:active { transform: scale(0.9); }

    .form-control:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.1);
        background-color: #fff;
    }
</style>
@endsection