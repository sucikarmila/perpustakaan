@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-5 animate__animated animate__fadeIn">
        <div>
            <h2 class="fw-800 text-dark mb-1 font-syne">Koleksi Pribadi</h2>
            <p class="text-muted small mb-0">Daftar buku favorit yang ingin Anda baca nanti.</p>
        </div>
        <div class="collection-stats bg-white px-4 py-2 rounded-pill shadow-sm border">
            <span class="fw-bold text-primary"><i class="fas fa-bookmark me-2"></i>{{ count($koleksi) }} Buku</span>
        </div>
    </div>

    <div class="row g-4">
        @forelse($koleksi as $k)
        <div class="col-md-6 col-lg-4 animate__animated animate__fadeInUp">
            <div class="card border-0 shadow-sm h-100 collection-card">
                <div class="card-body p-4"> <div class="d-flex">
                        <div class="flex-shrink-0">
                            <div class="book-cover-wrapper shadow">
                                @if($k->Gambar)
                                    <img src="{{ asset('storage/'.$k->Gambar) }}" class="rounded img-fluid" alt="{{ $k->Judul }}">
                                @else
                                    <div class="bg-light rounded d-flex align-items-center justify-content-center h-100 w-100">
                                        <i class="fas fa-image text-muted opacity-25"></i>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="ms-4 d-flex flex-column justify-content-between w-100">
                            <div>
                                <h6 class="fw-bold text-dark mb-1 text-truncate-2">{{ $k->Judul }}</h6>
                                <p class="text-muted extra-small mb-2">
                                    <i class="fas fa-pen-nib me-1"></i> {{ $k->Penulis ?? 'Anonim' }}
                                </p>
                                
                                @if($k->Stok > 0)
                                    <span class="badge bg-soft-primary text-primary extra-small rounded-pill px-3">
                                        Tersedia: {{ $k->Stok }}
                                    </span>
                                @else
                                    <span class="badge bg-soft-danger text-danger extra-small rounded-pill px-3">
                                        Stok Habis
                                    </span>
                                @endif
                            </div>

                            <div class="mt-3 d-flex align-items-center justify-content-between">
                                @if($k->Stok > 0)
                                    <a href="{{ route('pinjam.form', $k->BukuID) }}" class="btn btn-primary btn-sm rounded-pill px-4 fw-bold shadow-sm btn-action">
                                        Ajukan Pinjaman
                                    </a>
                                @else
                                    <button class="btn btn-light btn-sm rounded-pill px-4 fw-bold border text-muted" disabled>
                                        Pinjaman Ditutup
                                    </button>
                                @endif
                                
                                <form action="{{ route('koleksi.hapus', $k->KoleksiID) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-outline-danger btn-sm border-0 rounded-circle btn-delete-fav" 
                                            onclick="return confirm('Hapus dari koleksi?')" title="Hapus dari koleksi">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-12 text-center py-5">
            <div class="empty-state-icon mb-4">
                <i class="fas fa-folder-open fa-4x text-muted opacity-25"></i>
            </div>
            <h4 class="fw-bold text-dark">Koleksi Masih Kosong</h4>
            <p class="text-muted">Jelajahi galeri buku dan simpan buku favoritmu di sini.</p>
            <a href="/pinjam-buku" class="btn btn-primary rounded-pill px-5 py-2 mt-2 shadow">
                Mulai Cari Buku
            </a>
        </div>
        @endforelse
    </div>
</div>

<style>
    .bg-soft-danger {
        background-color: rgba(220, 53, 69, 0.1);
    }
    
    .font-syne { font-family: 'Syne', sans-serif; }
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 0.75rem; }
    .collection-card { transition: all 0.3s ease; border-radius: 20px; background: #ffffff; }
    .collection-card:hover { transform: translateY(-5px); box-shadow: 0 10px 25px rgba(0,0,0,0.08) !important; }
    .book-cover-wrapper { width: 100px; height: 140px; overflow: hidden; border-radius: 12px; }
    .book-cover-wrapper img { width: 100%; height: 100%; object-fit: cover; }
    .text-truncate-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    .bg-soft-primary { background-color: rgba(13, 110, 253, 0.1); }
    .btn-action { transition: all 0.3s ease; }
    .btn-action:hover { letter-spacing: 0.5px; box-shadow: 0 4px 12px rgba(13, 110, 253, 0.3); }
    .btn-delete-fav { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; transition: background 0.3s; }
    .btn-delete-fav:hover { background: #fff5f5; color: #dc3545; }
    .empty-state-icon { width: 120px; height: 120px; background: #fff; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
</style>
@endsection