@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5">
        <div>
            <h2 class="fw-800 text-dark mb-1 font-syne">Daftar Buku</h2>
            <p class="text-muted small mb-0">Temukan buku Digital dalam satu genggamanmu.</p>
        </div>
        <div class="search-box">
             </div>
    </div>

    <div class="row g-4">
        @foreach($buku as $b)
        <div class="col-6 col-md-4 col-lg-3">
            <div class="card book-card h-100 border-0 shadow-sm animate__animated animate__fadeInUp">
                <div class="position-relative overflow-hidden img-container">
                    @if($b->Gambar)
                        <img src="{{ asset('storage/'.$b->Gambar) }}" class="card-img-top book-cover" alt="{{ $b->Judul }}">
                    @else
                        <div class="bg-light d-flex flex-column align-items-center justify-content-center text-muted" style="height: 280px;">
                            <i class="fas fa-image fa-3x mb-2 opacity-25"></i>
                            <small>Tidak ada cover</small>
                        </div>
                    @endif
                    
                    <div class="status-badge">
                        @if($b->Stok > 0)
                            <span class="badge rounded-pill bg-success shadow">Tersedia: {{ $b->Stok }}</span>
                        @else
                            <span class="badge rounded-pill bg-danger shadow">Habis</span>
                        @endif
                    </div>
                </div>
                
                <div class="card-body d-flex flex-column p-3">
                    <h6 class="card-title fw-bold text-dark mb-1 text-truncate" title="{{ $b->Judul }}">
                        {{ $b->Judul }}
                    </h6>
                    <p class="text-muted extra-small mb-2"><i class="fas fa-pen-nib me-1"></i> {{ $b->Penulis ?? 'Penulis Anonim' }}</p>

                    <div class="review-preview mb-3">
                        @php $avgRating = $b->ulasan->avg('Rating') ?? 0; @endphp
                        <div class="d-flex align-items-center mb-2">
                            <div class="text-warning small me-2">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                                @endfor
                            </div>
                            <span class="extra-small text-muted">({{ $b->ulasan->count() }})</span>
                        </div>
                        
                        @forelse($b->ulasan->take(1) as $u)
                            <div class="qoute-box">
                                <p class="text-muted fst-italic extra-small mb-0">
                                    "{{ Str::limit($u->Ulasan, 45) }}"
                                </p>
                            </div>
                        @empty
                            <p class="extra-small text-muted fst-italic mb-0">Belum ada ulasan.</p>
                        @endforelse
                    </div>

                    <div class="mt-auto">
                        @if($b->Stok > 0)
                            <a href="{{ route('pinjam.form', $b->BukuID) }}" class="btn btn-primary w-100 rounded-pill btn-sm fw-bold py-2 shadow-sm btn-pinjam">
                                Pinjam Sekarang
                            </a>
                        @else
                            <button class="btn btn-light w-100 rounded-pill btn-sm fw-bold py-2 text-muted border" disabled>
                                Stok Kosong
                            </button>
                        @endif
                        
                        @if($b->ulasan->count() > 0)
                        <button class="btn btn-link w-100 btn-sm text-decoration-none text-primary fw-bold mt-1 shadow-none" 
                                data-bs-toggle="modal" data-bs-target="#modalUlasan{{ $b->BukuID }}" style="font-size: 0.7rem;">
                            Lihat Semua Ulasan
                        </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
</div>

@foreach($buku as $b)
<div class="modal fade" id="modalUlasan{{ $b->BukuID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            <div class="modal-header border-0 pb-0">
                <h5 class="modal-title fw-bold">Ulasan Pembaca</h5>
                <button type="button" class="btn-close shadow-none" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="text-center mb-4">
                    <h6 class="fw-bold mb-1">{{ $b->Judul }}</h6>
                    <div class="text-warning">
                        @php $avgRating = $b->ulasan->avg('Rating') ?? 0; @endphp
                        @for($i = 1; $i <= 5; $i++)
                            <i class="{{ $i <= $avgRating ? 'fas' : 'far' }} fa-star"></i>
                        @endfor
                        <span class="text-dark ms-2 fw-bold">{{ number_format($avgRating, 1) }}</span>
                    </div>
                </div>
                <hr class="opacity-10">
                @foreach($b->ulasan as $u)
                <div class="d-flex mb-4 p-3 bg-light rounded-4">
                    <div class="flex-shrink-0">
                        <div class="avatar-circle">
                            {{ strtoupper(substr($u->user->Username ?? 'U', 0, 1)) }}
                        </div>
                    </div>
                    <div class="ms-3">
                        <div class="d-flex justify-content-between">
                            <h6 class="fw-bold mb-0 small">{{ $u->user->Username ?? 'User' }}</h6>
                            <span class="text-warning extra-small">
                                {{ str_repeat('⭐', $u->Rating) }}
                            </span>
                        </div>
                        <p class="text-muted small my-2 lh-base">{{ $u->Ulasan }}</p>
                        <small class="text-uppercase fw-bold text-muted" style="font-size: 0.6rem; letter-spacing: 1px;">
                            {{ $u->created_at ? $u->created_at->diffForHumans() : '-' }}
                        </small>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endforeach

<style>
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 0.75rem; }
    
    .book-card {
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
        border-radius: 18px;
        overflow: hidden;
    }
    
    .book-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .img-container {
        border-radius: 18px 18px 0 0;
        height: 280px;
        background: #f8f9fa;
    }
    
    .book-cover {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }
    
    .book-card:hover .book-cover {
        transform: scale(1.1);
    }

    .status-badge {
        position: absolute;
        top: 15px;
        left: 15px;
        z-index: 2;
    }

    .qoute-box {
        background: #f1f5f9;
        padding: 8px 12px;
        border-radius: 10px;
        border-left: 3px solid #0d6efd;
    }

    .btn-pinjam {
        transition: all 0.3s;
    }
    .btn-pinjam:hover {
        letter-spacing: 1px;
        background-color: #0056b3;
    }

     .avatar-circle {
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, #0d6efd, #00d2ff);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 4px 10px rgba(13, 110, 253, 0.2);
    }
    
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection