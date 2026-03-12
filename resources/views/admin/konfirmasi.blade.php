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
            <i class="fas fa-check-circle me-1"></i> SETUJUI
        </button>
    </form>

    <form action="/tolak-pinjam/{{$p->PeminjamanID}}" method="POST" id="tolakForm{{$p->PeminjamanID}}">
        @csrf
        <button type="button" class="btn btn-sm btn-action delete shadow-sm" onclick="confirmTolak('{{$p->PeminjamanID}}')" title="Tolak">
            <i class="fas fa-times-circle me-1"></i> TOLAK
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
                            <td>
    <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3" data-bs-toggle="modal" data-bs-target="#modalBalasUlasan{{ $p->BukuID }}">
        <i class="fas fa-comments me-1"></i> Lihat & Balas
    </button>
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
    .rounded-4 { border-radius: 1rem !important; }
    .bg-soft-primary { background-color: #e7f1ff; }
    
    .avatar-circle {
        width: 40px;
        height: 40px;
        background: linear-gradient(45deg, #0d6efd, #0dcaf0);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
        box-shadow: 0 2px 5px rgba(13, 110, 253, 0.2);
    }

    .custom-badge-warning {
        background-color: #fff8eb;
        color: #f59e0b;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #fef3c7;
        display: inline-block;
    }
    .custom-badge-info {
        background-color: #f0f7ff;
        color: #3b82f6;
        padding: 6px 14px;
        border-radius: 50px;
        font-weight: 700;
        font-size: 0.75rem;
        border: 1px solid #dbeafe;
        display: inline-block;
    }

    .btn-action {
        padding: 8px 16px;
        border-radius: 12px;
        font-weight: 800;
        font-size: 0.7rem;
        letter-spacing: 1px;
        transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        border: none;
        display: flex;
        align-items: center;
        justify-content: center;
        text-transform: uppercase;
    }

    .btn-action.approve {
        background-color: #ecfdf5;
        color: #10b981;
        border: 1px solid #d1fae5;
    }

    .btn-action.approve:hover {
        background-color: #10b981;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-action.delete {
        background-color: #fff1f2;
        color: #f43f5e;
        border: 1px solid #ffe4e6;
    }

    .btn-action.delete:hover {
        background-color: #f43f5e;
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(244, 63, 94, 0.3);
    }

    .modal-content { border-radius: 20px !important; border: none; }
    .modal-header { border-bottom: 1px solid #f0f0f0; }
    .ulasan-item {
        transition: 0.3s;
        border: 1px solid #eee;
    }
    .ulasan-item:hover { border-color: #0d6efd; }
</style>
@foreach($peminjaman as $p)
<div class="modal fade" id="modalBalasUlasan{{ $p->BukuID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 25px;">
            <div class="modal-header border-0 bg-light px-4 py-3" style="border-radius: 25px 25px 0 0;">
                <h5 class="modal-title fw-bold text-dark"><i class="fas fa-star text-warning me-2"></i>Ulasan: {{ $p->buku->Judul }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" style="max-height: 400px; overflow-y: auto;">
                @forelse($p->buku->ulasan as $u)
                    <div class="mb-4 p-3 rounded-4 shadow-sm border {{ $u->BalasanAdmin ? 'bg-white' : 'bg-light' }}">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span class="fw-bold text-primary">{{ $u->user->Username }}</span>
                            <span class="text-warning small">{{ str_repeat('⭐', $u->Rating) }}</span>
                        </div>
                        <p class="text-muted small mb-2">"{{ $u->Ulasan }}"</p>
                        
                        @if($u->BalasanAdmin)
                            <div class="ms-4 p-2 border-start border-primary border-3 bg-soft-primary rounded">
                                <small class="fw-bold d-block text-primary"><i class="fas fa-reply me-1"></i>Balasan Admin:</small>
                                <p class="small mb-0 text-dark fst-italic">{{ $u->BalasanAdmin }}</p>
                            </div>
                        @else
                            <form action="{{ route('admin.balas.ulasan', $u->UlasanID) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="input-group input-group-sm">
                                    <input type="text" name="BalasanAdmin" class="form-control border-primary-subtle" placeholder="Tulis balasan..." required>
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </form>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-4">
                        <i class="fas fa-comment-slash fa-3x text-light mb-2"></i>
                        <p class="text-muted small">Belum ada ulasan untuk buku ini.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endforeach
@endsection