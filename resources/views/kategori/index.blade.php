@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Kelola Kategori</h3>
            <p class="text-muted small">Organisir kategori buku untuk mempermudah pencarian koleksi.</p>
        </div>
        <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addKategori">
            <i class="fas fa-plus-circle me-2"></i>Tambah Kategori
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success border-0 shadow-sm rounded-4 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold" width="10%">ID</th>
                            <th class="py-3 text-uppercase small fw-bold" width="20%">Nama Kategori</th>
                            <th class="py-3 text-uppercase small fw-bold">Koleksi Buku</th>
                            <th class="py-3 text-uppercase small fw-bold text-center" width="15%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($kategori as $k)
                        <tr>
                            <td class="px-4"><span class="fw-bold text-dark">{{ $k->KategoriID }}</span></td>
                            <td>
                                <span class="custom-badge-category">
                                    {{ $k->NamaKategori }}
                                </span>
                            </td>
                            <td>
                                @if($k->buku->count() > 0)
                                    <div class="d-flex flex-wrap gap-2">
                                        @foreach($k->buku as $buku)
                                            <button type="button" 
                                                    class="btn-book-tag" 
                                                    data-bs-toggle="modal" 
                                                    data-bs-target="#detailBuku{{ $buku->BukuID }}">
                                                <i class="fas fa-book me-1"></i> {{ $buku->Judul }}
                                            </button>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-muted fst-italic small">Belum ada buku</span>
                                @endif
                            </td>
                            <td class="text-center">
                                <div class="btn-group gap-2">
                                    <button class="btn btn-sm btn-action edit" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#editKategori{{ $k->KategoriID }}"
                                            title="Edit Kategori">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <form action="/kategori/{{ $k->KategoriID }}" method="POST" id="deleteForm{{ $k->KategoriID }}" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-action delete" onclick="confirmDelete('{{ $k->KategoriID }}')" title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addKategori" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="/kategori" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-primary"><i class="fas fa-folder-plus me-2"></i>Tambah Kategori</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body px-4">
                <div class="form-group mb-3">
                    <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                    <input type="text" name="NamaKategori" class="form-control form-control-lg rounded-4 shadow-sm border-light" placeholder="Misal: Teknologi, Sejarah..." required>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan Kategori</button>
            </div>
        </form>
    </div>
</div>

@foreach($kategori as $k)
    <div class="modal fade" id="editKategori{{ $k->KategoriID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <form action="/kategori/{{ $k->KategoriID }}" method="POST" class="modal-content border-0 shadow-lg" style="border-radius: 20px;">
                @csrf
                @method('PUT')
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="modal-title fw-bold text-primary"><i class="fas fa-edit me-2"></i>Edit Nama Kategori</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body px-4">
                    <div class="form-group mb-3">
                        <label class="form-label small fw-bold text-muted text-uppercase">Nama Kategori</label>
                        <input type="text" name="NamaKategori" class="form-control form-control-lg rounded-4 shadow-sm border-light" value="{{ $k->NamaKategori }}" required>
                    </div>
                </div>
                <div class="modal-footer border-0 pb-4 px-4">
                    <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary rounded-pill px-4 shadow">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    @foreach($k->buku as $buku)
    <div class="modal fade" id="detailBuku{{ $buku->BukuID }}" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg overflow-hidden" style="border-radius: 20px;">
                <div class="modal-body p-0">
                    <div class="row g-0">
                        <div class="col-md-5 bg-light d-flex align-items-center justify-content-center p-4 border-end">
                            @if($buku->Gambar)
                                <img src="{{ asset('storage/'.$buku->Gambar) }}" class="img-fluid rounded-3 shadow" style="max-height: 350px; object-fit: cover;">
                            @else
                                <div class="text-center text-muted">
                                    <i class="fas fa-book-open fa-4x mb-3 opacity-25"></i><br>
                                    <small>Sampul tidak tersedia</small>
                                </div>
                            @endif
                        </div>
                        <div class="col-md-7 p-4">
                            <div class="d-flex justify-content-between mb-3">
                                <span class="badge bg-soft-primary text-primary">{{ $k->NamaKategori }}</span>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                            </div>
                            <h4 class="fw-bold text-dark">{{ $buku->Judul }}</h4>
                            <p class="text-muted"><i class="fas fa-user-edit me-1"></i> {{ $buku->Penulis }}</p>
                            
                            <hr class="opacity-10">
                            
                            <div class="row g-3 mb-4">
                                <div class="col-6">
                                    <label class="text-muted small d-block">Penerbit</label>
                                    <span class="fw-semibold">{{ $buku->Penerbit }}</span>
                                </div>
                                <div class="col-6">
                                    <label class="text-muted small d-block">Tahun Terbit</label>
                                    <span class="fw-semibold">{{ $buku->TahunTerbit }}</span>
                                </div>
                            </div>

                            <label class="fw-bold text-dark mb-1 small text-uppercase" style="letter-spacing: 1px;">Deskripsi</label>
                            <div class="p-3 bg-light rounded-4">
                                <p class="text-muted small mb-0" style="line-height: 1.6;">
                                    {{ $buku->Deskripsi ?? 'Penjelasan mengenai buku ini belum tersedia di sistem.' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endforeach
@endforeach

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Data yang dihapus tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                document.getElementById('deleteForm' + id).submit();
            }
        })
    }
</script>

<style>
    .custom-badge-category {
        background-color: #f0f7ff;
        color: #0d6efd;
        padding: 6px 16px;
        border-radius: 50px;
        font-weight: 600;
        font-size: 0.85rem;
        border: 1px solid #cfe2ff;
    }
    .btn-book-tag {
        background: #ffffff;
        border: 1px solid #dee2e6;
        border-radius: 8px;
        padding: 4px 12px;
        font-size: 0.75rem;
        color: #495057;
        transition: 0.2s;
    }
    .btn-book-tag:hover {
        background: #0d6efd;
        color: white;
        border-color: #0d6efd;
    }
    .btn-action {
        width: 38px;
        height: 38px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .btn-action.edit { 
        background: #e7f1ff; 
        color: #0d6efd; 
        border: 1px solid #cfe2ff; 
    }
    .btn-action.edit:hover { 
        background: #0d6efd; 
        color: white; 
    }
    .btn-action.delete { 
        background: #fff5f5; 
        color: #dc3545; 
        border: 1px solid #ffe3e3; 
    }
    .btn-action.delete:hover { 
        background: #dc3545; 
        color: white; 
    }
    .bg-soft-primary { background-color: #e7f1ff; }
    .rounded-4 { border-radius: 1rem !important; }
</style>
@endsection