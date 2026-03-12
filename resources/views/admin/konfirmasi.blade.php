@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Konfirmasi Peminjaman</h3>
            <p class="text-muted small">Kelola persetujuan pinjam dan pengembalian buku dalam satu tempat.</p>
        </div>
        <div class="text-end">
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                <i class="fas fa-info-circle me-1"></i> {{ $peminjaman->count() }} Permintaan Butuh Tindakan
            </span>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold">Peminjam</th>
                            <th class="py-3 text-uppercase small fw-bold">Detail Buku</th>
                            <th class="py-3 text-uppercase small fw-bold">Tanggal Pinjam</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Status</th>
                            <th class="py-3 text-uppercase small fw-bold text-center" width="20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($peminjaman as $p)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-circle me-3">
                                        {{ substr($p->user->Username, 0, 1) }}
                                    </div>
                                    <div>
                                        <div class="fw-bold text-dark">{{ $p->user->Username }}</div>
                                        <small class="text-muted">{{ $p->user->Email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="fw-semibold text-primary">{{ $p->buku->Judul }}</div>
                                <small class="text-muted">ID: #{{ $p->BukuID }}</small>
                            </td>
                            <td>
                                <div class="text-dark">{{ \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d M Y') }}</div>
                                <small class="text-muted fst-italic">Oleh Admin/Sistem</small>
                            </td>
                            <td class="text-center">
                                @if($p->StatusPeminjaman == 'Menunggu Persetujuan')
                                    <span class="custom-badge-warning">Butuh Persetujuan</span>
                                @else
                                    <span class="custom-badge-info">Proses Kembali</span>
                                @endif
                            </td>
                            <td class="px-4 text-center">
                                @if($p->StatusPeminjaman == 'Menunggu Persetujuan')
                                    <div class="d-flex justify-content-center gap-2">
                                        <form action="/setujui-pinjam/{{$p->PeminjamanID}}" method="POST">
                                            @csrf
                                            <button class="btn btn-sm btn-action approve shadow-sm" title="Setujui">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                        <form action="/tolak-pinjam/{{$p->PeminjamanID}}" method="POST" id="tolakForm{{$p->PeminjamanID}}">
                                            @csrf
                                            <button type="button" class="btn btn-sm btn-action delete shadow-sm" onclick="confirmTolak('{{$p->PeminjamanID}}')" title="Tolak">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </form>
                                    </div>
                                @elseif($p->StatusPeminjaman == 'Menunggu Konfirmasi Kembali')
                                    <form action="/setujui-kembali/{{$p->PeminjamanID}}" method="POST">
                                        @csrf
                                        <button class="btn btn-primary btn-sm rounded-pill px-4 shadow-sm fw-bold">
                                            <i class="fas fa-file-import me-1"></i> Konfirmasi Terima
                                        </button>
                                    </form>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center py-5">
                                <i class="fas fa-clipboard-check fa-3x text-light mb-3"></i>
                                <p class="text-muted mb-0">Semua permintaan telah diproses.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmTolak(id) {
        Swal.fire({
            title: 'Tolak Peminjaman?',
            text: "Permintaan peminjaman ini akan dibatalkan secara permanen.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Tolak!',
            cancelButtonText: 'Batal',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('tolakForm' + id).submit();
            }
        })
    }
</script>

<style>
    /* Styling Badge Kustom */
    .custom-badge-warning {
        background-color: #fff8eb;
        color: #ffb020;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        border: 1px solid #ffe8cc;
    }
    .custom-badge-info {
        background-color: #f0f7ff;
        color: #0d6efd;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.8rem;
        border: 1px solid #cfe2ff;
    }
    
    /* Tombol Aksi */
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
        border: none;
    }
    .btn-action.approve {
        background: #e6fffa;
        color: #38a169;
    }
    .btn-action.approve:hover {
        background: #38a169;
        color: white;
    }
    .btn-action.delete { 
        background: #fff5f5; 
        color: #dc3545; 
    }
    .btn-action.delete:hover { 
        background: #dc3545; 
        color: white; 
    }

    /* Avatar Inisial */
    .avatar-circle {
        width: 40px;
        height: 40px;
        background-color: #0d6efd;
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        text-transform: uppercase;
    }

    .bg-soft-primary { background-color: #e7f1ff; }
</style>
@endsection