@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4 d-print-none">
        <div>
            <h3 class="fw-bold text-primary mb-0">Laporan Aktivitas Perpustakaan</h3>
            <p class="text-muted small">Ekspor data riwayat peminjaman buku ke format cetak/PDF.</p>
        </div>
        <button onclick="window.print()" class="btn btn-primary rounded-pill px-4 shadow-sm">
            <i class="fas fa-print me-2"></i> Cetak Laporan
        </button>
    </div>
    <div class="card border-0 shadow-sm rounded-4 mb-4 d-print-none">
        <div class="card-body p-3">
            <form action="{{ url('/laporan') }}" method="GET" class="row g-2 align-items-end">
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Mulai Tanggal</label>
                    <input type="date" name="start_date" class="form-control rounded-3" value="{{ request('start_date') }}">
                </div>
                <div class="col-md-4">
                    <label class="form-label small fw-bold text-muted">Sampai Tanggal</label>
                    <input type="date" name="end_date" class="form-control rounded-3" value="{{ request('end_date') }}">
                </div>
                <div class="col-md-4 d-flex gap-2">
                    <button type="submit" class="btn btn-primary w-100 rounded-3 fw-bold">
                        <i class="fas fa-filter me-1"></i> Filter
                    </button>
                    <a href="{{ url('/laporan') }}" class="btn btn-light border w-100 rounded-3 fw-bold text-muted">
                        <i class="fas fa-undo me-1"></i> Reset
                    </a>
                </div>
            </form>
        </div>
    </div>
    <div class="print-header d-none d-print-block">
        <div class="d-flex align-items-center justify-content-center mb-2">
            <div class="me-3">
                <i class="fas fa-book-reader fa-3x text-primary"></i>
            </div>
            <div class="text-center">
                <h2 class="fw-bold text-uppercase mb-0" style="letter-spacing: 2px; font-size: 22px;">Laporan Riwayat Peminjaman Buku</h2>
                <h4 class="text-primary mb-0" style="font-size: 18px;">E-PERPUS DIGITAL LIBRARY</h4>
                <p class="mb-0 small text-muted">Jl. Perpustakaan No. 123, Kota Anda | Telp: (021) 12345678</p>
            </div>
        </div>
        <hr style="border-top: 3px double #333; opacity: 1; margin-top: 10px; margin-bottom: 20px;">
<p class="text-end small mb-4">Tanggal Cetak: <strong>{{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->translatedFormat('d F Y, H:i') }}</strong></p>
    </div>

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden card-print">
        <div class="card-body p-0">
            <table class="table table-striped table-bordered align-middle mb-0" id="reportTable">
                <thead class="bg-dark text-white">
                    <tr>
                        <th class="text-center py-3">NO</th>
                        <th>PEMINJAM</th>
                        <th>BUKU</th>
                        <th class="text-center">TGL PINJAM</th>
                        <th class="text-center">TGL KEMBALI</th>
                        <th class="text-center">STATUS</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($laporan as $index => $p)
                    <tr>
                        <td class="text-center small">{{ $index + 1 }}</td>
                        <td class="ps-3">
                            <div class="fw-bold text-dark">{{ $p->user->Username }}</div>
                            <small class="text-muted" style="font-size: 11px;">{{ $p->user->Email }}</small>
                        </td>
                        <td class="ps-3">
                            <div class="fw-semibold text-dark">{{ $p->buku->Judul }}</div>
                            <small class="text-muted" style="font-size: 11px;">ID: #{{ $p->BukuID }}</small>
                        </td>
                        <td class="text-center small">{{ date('d/m/Y', strtotime($p->TanggalPeminjaman)) }}</td>
                        <td class="text-center small">
                            {{ $p->TanggalPengembalian ? date('d/m/Y', strtotime($p->TanggalPengembalian)) : '-' }}
                        </td>
                        <td class="text-center small">
                            <span class="d-print-none badge {{ $p->StatusPeminjaman == 'kembali' ? 'bg-success' : 'bg-warning text-dark' }}">
                                {{ ucfirst($p->StatusPeminjaman) }}
                            </span>
                            <span class="d-none d-print-block fw-bold">
                                {{ ucfirst($p->StatusPeminjaman) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="text-center py-5">Data tidak tersedia.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-none d-print-block mt-5">
        <div class="row">
            <div class="col-8"></div>
            <div class="col-4 text-center">
                <p class="mb-5">Mengetahui, <br> <strong>Kepala Perpustakaan</strong></p>
                <br><br>
                <p class="mb-0 fw-bold text-decoration-underline">( ____________________ )</p>
                <p class="small text-muted">NIP. 123456789</p>
            </div>
        </div>
    </div>
</div>

<style>
    .table thead th { font-size: 12px; letter-spacing: 1px; }
    .card-print { border: none; }

    @media print {
        @page {
            size: A4;
            margin: 1.5cm; 
        }
        
        body {
            background-color: #fff !important;
            font-size: 12px !important;
            color: #000 !important;
        }

        .container-fluid { padding: 0 !important; }
        
        .table-bordered { border: 1px solid #000 !important; }
        .table-bordered th, .table-bordered td { border: 1px solid #000 !important; padding: 8px !important; }
        
        .table thead th {
            background-color: #f2f2f2 !important;
            color: #000 !important;
            -webkit-print-color-adjust: exact;
        }

        .card-print { border: none !important; box-shadow: none !important; }
        
        img, .d-print-none { display: none !important; }

        .d-print-block { display: block !important; }
    }
</style>
@endsection