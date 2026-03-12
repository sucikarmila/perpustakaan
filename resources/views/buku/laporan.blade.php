@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h3 class="fw-bold text-primary mb-0">Laporan Riwayat Peminjaman</h3>
            <p class="text-muted small">Cetak laporan aktivitas peminjaman buku perpustakaan.</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>

    <div class="d-none d-print-block text-center mb-4">
        <h2 class="fw-bold text-uppercase mb-1">Laporan Riwayat Peminjaman Buku</h2>
        <h4 class="mb-2">Perpustakaan Digital E-PERPUS</h4>
        <p class="text-muted small">Dicetak pada: {{ date('d F Y, H:i') }}</p>
        <hr style="border: 2px solid #000;">
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-primary text-white text-center">
                        <tr>
                            <th width="50" class="py-3">No</th>
                            <th class="text-start">Informasi Peminjam</th>
                            <th class="text-start">Buku yang Dipinjam</th>
                            <th>Tgl Pinjam</th>
                            <th>Tgl Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($laporan as $index => $p)
                        <tr>
                            <td class="text-center fw-bold text-muted">{{ $index + 1 }}</td>
                            <td class="px-3">
                                <span class="fw-bold text-dark">{{ $p->user->Username }}</span><br>
                                <small class="text-muted">{{ $p->user->Email }}</small>
                            </td>
                            <td class="px-3">
                                <div class="d-flex align-items-center">
                                    @if($p->buku->Gambar)
                                        <img src="{{ asset('storage/'.$p->buku->Gambar) }}" width="40" height="55" class="rounded me-2 shadow-sm d-print-none" style="object-fit: cover;">
                                    @endif
                                    <div>
                                        {{-- PERBAIKAN DI SINI --}}
                                        <strong class="text-dark">{{ $p->buku->Judul }}</strong><br>
                                        <small class="text-muted">ID: {{ $p->BukuID }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="text-center">{{ date('d/m/Y', strtotime($p->TanggalPeminjaman)) }}</td>
                            <td class="text-center">
                                @if($p->TanggalPengembalian)
                                    {{ date('d/m/Y', strtotime($p->TanggalPengembalian)) }}
                                @else
                                    <span class="text-danger small fw-bold">-</span>
                                @endif
                            </td>
                            <td class="text-center">
                                @if($p->StatusPeminjaman == 'dipinjam')
                                    <span class="badge bg-warning text-dark px-3 rounded-pill">Dipinjam</span>
                                @elseif($p->StatusPeminjaman == 'kembali')
                                    <span class="badge bg-success px-3 rounded-pill">Selesai</span>
                                @else
                                    <span class="badge bg-secondary px-3 rounded-pill">{{ ucfirst($p->StatusPeminjaman) }}</span>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted fst-italic">Belum ada data riwayat peminjaman.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection