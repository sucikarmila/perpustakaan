@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h3 class="fw-bold text-primary mb-0">Kelola Buku</h3>
        <p class="text-muted small">Kelola katalog buku, stok, dan informasi kategori perpustakaan.</p>
    </div>
    <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#modalTambah">
        <i class="fas fa-plus-circle me-2"></i>Tambah Buku
    </button>
</div>

<div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                    <tr>
                        <th class="px-4 py-3 text-uppercase small fw-bold" width="10%">Cover</th>
                        <th class="py-3 text-uppercase small fw-bold" width="30%">Informasi Buku</th>
                        <th class="py-3 text-uppercase small fw-bold">Penulis</th>
                        <th class="py-3 text-uppercase small fw-bold">Kategori</th>
                        <th class="py-3 text-uppercase small fw-bold text-center">Stok</th>
                        <th class="py-3 text-uppercase small fw-bold text-center" width="15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($buku as $b)
                    <tr>
                        <td class="px-4">
                            @if($b->Gambar)
                                <img src="{{ asset('storage/'.$b->Gambar) }}" class="rounded shadow-sm img-cover-table">
                            @else
                                <div class="no-image-placeholder rounded">
                                    <i class="fas fa-image opacity-25"></i>
                                </div>
                            @endif
                        </td>
                        <td>
                            <span class="fw-bold text-dark d-block mb-1">{{ $b->Judul }}</span>
                            <p class="text-muted small mb-0 lh-sm">{{ Str::limit($b->Deskripsi, 60) }}</p>
                        </td>
                        <td><span class="text-secondary small fw-semibold">{{ $b->Penulis }}</span></td>
                        <td>
                            <span class="badge rounded-pill bg-soft-info text-info px-3">
                                {{ $b->kategori->NamaKategori ?? 'Uncategorized' }}
                            </span>
                        </td>
                        <td class="text-center">
                            <span class="badge {{ $b->Stok > 0 ? 'bg-light text-dark' : 'bg-danger text-white' }} border px-3">
                                {{ $b->Stok }}
                            </span>
                        </td> 
                        <td class="text-center">
                            <div class="btn-group">
                                <button class="btn btn-sm btn-action edit-blue" data-bs-toggle="modal" data-bs-target="#editBuku{{ $b->BukuID }}" title="Edit">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <form action="{{ route('buku.destroy', $b->BukuID) }}" method="POST" class="d-inline ms-1">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-sm btn-action delete" onclick="confirmDelete(this)" title="Hapus">
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('buku.store') }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow" style="border-radius: 20px;">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-primary"><i class="fas fa-book-medical me-2"></i>Tambah Buku Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted">Judul Buku</label>
                        <input type="text" name="Judul" class="form-control rounded-3" placeholder="Masukkan judul lengkap" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted">Penulis</label>
                        <input type="text" name="Penulis" class="form-control rounded-3" placeholder="Nama penulis" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Penerbit</label>
                        <input type="text" name="Penerbit" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Tahun</label>
                        <input type="number" name="TahunTerbit" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Stok</label>
                        <input type="number" name="Stok" class="form-control rounded-3" required min="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select name="KategoriID" class="form-select rounded-3" required>
                            <option value="" selected disabled>Pilih Kategori...</option>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}">{{ $k->NamaKategori }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Deskripsi / Sinopsis</label>
                        <textarea name="Deskripsi" class="form-control rounded-3" rows="3" placeholder="Garis besar cerita..."></textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Gambar Cover</label>
                        <input type="file" name="Gambar" class="form-control rounded-3">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Simpan Buku</button>
            </div>
        </form>
    </div>
</div>

@foreach($buku as $b)
<div class="modal fade" id="editBuku{{ $b->BukuID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg">
        <form action="{{ route('buku.update', $b->BukuID) }}" method="POST" enctype="multipart/form-data" class="modal-content border-0 shadow" style="border-radius: 20px;">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="modal-title fw-bold text-primary"><i class="fas fa-edit me-2"></i>Edit Buku</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4">
                <div class="row g-3">
                    <div class="col-md-7">
                        <label class="form-label small fw-bold text-muted">Judul Buku</label>
                        <input type="text" name="Judul" value="{{ $b->Judul }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-5">
                        <label class="form-label small fw-bold text-muted">Penulis</label>
                        <input type="text" name="Penulis" value="{{ $b->Penulis }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label small fw-bold text-muted">Penerbit</label>
                        <input type="text" name="Penerbit" value="{{ $b->Penerbit }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Tahun</label>
                        <input type="number" name="TahunTerbit" value="{{ $b->TahunTerbit }}" class="form-control rounded-3" required>
                    </div>
                    <div class="col-md-3">
                        <label class="form-label small fw-bold text-muted">Stok</label>
                        <input type="number" name="Stok" value="{{ $b->Stok }}" class="form-control rounded-3" required min="0">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Kategori</label>
                        <select name="KategoriID" class="form-select rounded-3" required>
                            @foreach($kategori as $k)
                                <option value="{{ $k->KategoriID }}" {{ $b->KategoriID == $k->KategoriID ? 'selected' : '' }}>
                                    {{ $k->NamaKategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Deskripsi</label>
                        <textarea name="Deskripsi" class="form-control rounded-3" rows="3">{{ $b->Deskripsi }}</textarea>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label small fw-bold text-muted">Ganti Gambar (Biarkan kosong jika tidak diubah)</label>
                        <input type="file" name="Gambar" class="form-control rounded-3">
                    </div>
                </div>
            </div>
            <div class="modal-footer border-0 pb-4 px-4">
                <button type="button" class="btn btn-light rounded-pill px-4" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-primary rounded-pill px-4 shadow-sm">Update Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .img-cover-table {
        width: 60px;
        height: 80px;
        object-fit: cover;
    }
    .no-image-placeholder {
        width: 60px;
        height: 80px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        border: 1px dashed #dee2e6;
    }
    .bg-soft-info { background-color: #e0f7fa; }
    .btn-action {
        width: 35px;
        height: 35px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        transition: 0.3s;
    }
    .btn-action.edit-blue { 
        background: #e7f1ff; 
        color: #0d6efd; 
        border: 1px solid #cfe2ff; 
    }
    .btn-action.delete { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
    .btn-action:hover { transform: scale(1.1); filter: brightness(0.9); }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.confirmDelete = function(button) {
        Swal.fire({
            title: 'Hapus buku ini?',
            text: "Data ulasan dan peminjaman terkait juga akan ikut terhapus!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal',
            borderRadius: '15px'
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    @if(session('success'))
        Swal.fire({
            icon: 'success',
            title: 'Berhasil!',
            text: "{{ session('success') }}",
            showConfirmButton: false,
            timer: 2000
        });
    @endif
</script>
@endpush
@endsection