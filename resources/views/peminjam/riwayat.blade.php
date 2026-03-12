@extends('layouts.app')

@section('content')
<div class="container py-5">
    <div class="d-flex align-items-center justify-content-between mb-4">
        <div>
            <h2 class="fw-800 text-dark mb-1 font-syne">Riwayat Peminjaman</h2>
            <p class="text-muted small">Pantau status buku yang Anda pinjam dan riwayat literasi Anda.</p>
        </div>
        <div class="badge bg-soft-primary text-primary p-2 px-3 rounded-pill">
            <i class="fas fa-book-reader me-2"></i>{{ $pinjaman->count() }} Transaksi
        </div>
    </div>

    <div class="card shadow-sm border-0 overflow-hidden" style="border-radius: 20px;">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold text-muted">Informasi Buku</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Waktu Pinjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Tenggat Kembali</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-muted">Total Biaya</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pinjaman as $p)
                        @php
                            $deadline = \Carbon\Carbon::parse($p->TanggalPengembalian);
                            $hampir_habis = now()->diffInDays($deadline, false) <= 2 && now() < $deadline;
                            $terlambat = now() > $deadline && $p->StatusPeminjaman == 'Dipinjam';
                        @endphp
                        <tr>
                            <td class="px-4 py-3">
                                <div class="d-flex align-items-center">
                                    <div class="book-icon-sm me-3">
                                        <i class="fas fa-book text-primary"></i>
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->buku->Judul }}</div>
                                        <small class="text-muted">{{ $p->buku->Penulis }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="small fw-semibold text-dark">{{ \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d M Y') }}</div>
                            </td>
                            <td>
                                <div class="small">
                                    <span class="{{ $terlambat ? 'text-danger fw-bold' : ($hampir_habis ? 'text-warning fw-bold' : 'text-dark fw-semibold') }}">
                                        {{ \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d M Y') }}
                                    </span>
                                    @if($terlambat) 
                                        <span class="ms-1 badge bg-soft-danger text-danger extra-small"><i class="fas fa-exclamation-triangle"></i> Terlambat</span>
                                    @elseif($hampir_habis && $p->StatusPeminjaman == 'Dipinjam') 
                                        <span class="ms-1 badge bg-soft-warning text-warning extra-small"><i class="fas fa-clock"></i> Segera</span>
                                    @endif
                                </div>
                            </td>
<td>
    @if($p->StatusPeminjaman == 'Menunggu Persetujuan')
        <span class="badge rounded-pill bg-warning text-dark">Menunggu Persetujuan</span>
    @elseif($p->StatusPeminjaman == 'Dipinjam')
        <span class="badge rounded-pill bg-info text-white">Sedang Dipinjam</span>
    @elseif($p->StatusPeminjaman == 'Menunggu Konfirmasi Kembali')
        <span class="badge rounded-pill bg-secondary text-white">Proses Pengembalian</span>
    @else
        <span class="badge rounded-pill bg-success text-white">Selesai</span>
    @endif
</td>
                            <td>
                                <div class="fw-bold text-dark small">
                                    Rp {{ number_format($p->Denda + $p->BiayaTambahan, 0, ',', '.') }}
                                </div>
                                @if($p->Denda > 0)
                                    <small class="text-danger" style="font-size: 0.65rem;">(Termasuk Denda)</small>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->StatusPeminjaman == 'Dipinjam')
                                    <button class="btn btn-primary btn-sm rounded-pill px-3 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalKembali{{$p->PeminjamanID}}">
                                        <i class="fas fa-undo me-1"></i> Kembali
                                    </button>
                                @else
    <div class="d-flex gap-2 justify-content-center">
        <a href="{{ route('ulasan.tulis', $p->BukuID) }}" class="btn btn-warning btn-sm rounded-pill px-3 text-white shadow-sm">
            <i class="fas fa-star me-1"></i> Ulas
        </a>
        <a href="{{ route('nota', $p->PeminjamanID) }}" target="_blank" class="btn btn-outline-secondary btn-sm rounded-pill px-3 shadow-sm">
            <i class="fas fa-print me-1"></i> Nota
        </a>
    </div>
@endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@foreach($pinjaman as $p)
    @if($p->StatusPeminjaman == 'Dipinjam')
    <div class="modal fade" id="modalKembali{{$p->PeminjamanID}}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
                <form action="/kembalikan-buku/{{$p->PeminjamanID}}" method="POST">
                    @csrf
                    <div class="modal-body p-4 p-lg-5">
                        <div class="text-center mb-4">
                            <div class="icon-circle bg-soft-danger text-danger mb-3 mx-auto shadow-sm">
                                <i class="fas fa-hand-holding-heart fa-2x"></i>
                            </div>
                            <h4 class="fw-bold text-dark">Kembalikan Buku?</h4>
                            <p class="text-muted small">Harap periksa kondisi fisik buku <br><strong class="text-primary">"{{ $p->buku->Judul }}"</strong></p>
                        </div>

                        <div class="condition-picker mb-4">
                            <label class="fw-bold text-dark small mb-3 text-uppercase letter-spacing-1">Kondisi Buku Saat Ini:</label>
                            
                            <input type="radio" class="btn-check" name="denda_rusak" id="baik{{$p->PeminjamanID}}" value="0" checked autocomplete="off">
                            <label class="btn btn-outline-success w-100 rounded-4 p-3 mb-2 text-start d-flex justify-content-between align-items-center" for="baik{{$p->PeminjamanID}}">
                                <span><i class="fas fa-check-circle me-2"></i> Kondisi Baik</span>
                                <span class="badge bg-success shadow-sm">Gratis</span>
                            </label>

                            <input type="radio" class="btn-check" name="denda_rusak" id="ringan{{$p->PeminjamanID}}" value="20000" autocomplete="off">
                            <label class="btn btn-outline-warning w-100 rounded-4 p-3 mb-2 text-start d-flex justify-content-between align-items-center" for="ringan{{$p->PeminjamanID}}">
                                <span><i class="fas fa-tools me-2"></i> Rusak Ringan</span>
                                <span class="badge bg-warning text-dark shadow-sm">Rp 20.000</span>
                            </label>

                            <input type="radio" class="btn-check" name="denda_rusak" id="berat{{$p->PeminjamanID}}" value="50000" autocomplete="off">
                            <label class="btn btn-outline-danger w-100 rounded-4 p-3 text-start d-flex justify-content-between align-items-center" for="berat{{$p->PeminjamanID}}">
                                <span><i class="fas fa-heart-broken me-2"></i> Rusak Berat/Hilang</span>
                                <span class="badge bg-danger shadow-sm">Rp 50.000</span>
                            </label>
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-primary btn-lg rounded-pill fw-bold py-3 shadow-sm border-0 bg-primary-gradient">
                                Konfirmasi Pengembalian
                            </button>
                            <button type="button" class="btn btn-link text-muted text-decoration-none small mt-1" data-bs-dismiss="modal">Batalkan</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
@endforeach

<style>
    .fw-800 { font-weight: 800; }
    .extra-small { font-size: 0.65rem; }
    .letter-spacing-1 { letter-spacing: 1px; }

    .book-icon-sm {
        width: 40px; height: 40px;
        background: #f0f7ff;
        border-radius: 12px;
        display: flex; align-items: center; justify-content: center;
        font-size: 1.1rem;
    }

    .bg-soft-info { background-color: #e0f7fa; }
    .bg-soft-success { background-color: #e8f5e9; }
    .bg-soft-danger { background-color: #ffebee; }
    .bg-soft-warning { background-color: #fffde7; }

    .icon-circle {
        width: 80px; height: 80px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
    }

    .btn-check:checked + .btn-outline-success { background-color: #e8f5e9; border-color: #28a745; color: #155724; }
    .btn-check:checked + .btn-outline-warning { background-color: #fffde7; border-color: #ffc107; color: #856404; }
    .btn-check:checked + .btn-outline-danger { background-color: #ffebee; border-color: #dc3545; color: #721c24; }
    
    .rounded-4 { border-radius: 1rem !important; }

    .table-hover tbody tr:hover {
        background-color: #fbfcfe;
        transition: background-color 0.2s ease;
    }
</style>
@endsection