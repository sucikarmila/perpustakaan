@extends('layouts.app')

@section('content')
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="fw-bold text-primary mb-0">Kelola User & Petugas</h3>
            <p class="text-muted small">Kelola hak akses admin dan petugas perpustakaan.</p>
        </div>
        <button class="btn btn-primary rounded-pill shadow-sm px-4" data-bs-toggle="modal" data-bs-target="#modalTambah">
            <i class="fas fa-user-plus me-2"></i> Tambah Akun
        </button>
    </div>

    @if(session('error'))
    <div class="alert alert-danger alert-dismissible fade show border-0 shadow-sm rounded-4 mb-4" role="alert">
        <div class="d-flex align-items-center">
            <i class="fas fa-exclamation-circle me-3 fs-4"></i>
            <div>
                <span class="fw-bold">Gagal!</span> {{ session('error') }}
            </div>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="card border-0 shadow-sm rounded-4 overflow-hidden">
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light text-secondary">
                        <tr>
                            <th class="px-4 py-3 text-uppercase small fw-bold">Pengguna</th>
                            <th class="py-3 text-uppercase small fw-bold">Email</th>
                            <th class="py-3 text-uppercase small fw-bold">Role</th>
                            <th class="py-3 text-uppercase small fw-bold text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $u)
                        <tr>
                            <td class="px-4">
                                <div class="d-flex align-items-center">
                                    <div class="rounded-circle bg-soft-primary text-primary d-flex align-items-center justify-content-center me-3 shadow-sm fw-bold" style="width: 40px; height: 40px; border: 1px solid #d0e6ff;">
                                        {{ strtoupper(substr($u->Username, 0, 1)) }}
                                    </div>
                                    <span class="fw-bold text-dark">{{ $u->Username }}</span>
                                </div>
                            </td>
                            <td class="text-muted small">{{ $u->Email }}</td>
                            <td>
                                @php
                                    $roleClass = [
                                        'admin' => 'bg-danger-subtle text-danger border-danger',
                                        'petugas' => 'bg-success-subtle text-success border-success'
                                    ][$u->Role] ?? 'bg-light text-dark';
                                @endphp
                                <span class="badge rounded-pill px-3 py-2 border {{ $roleClass }}" style="font-size: 0.75rem;">
                                    <i class="fas fa-circle me-1" style="font-size: 0.5rem;"></i> {{ ucfirst($u->Role) }}
                                </span>
                            </td>
                            <td class="text-center">
                                <div class="btn-group">
                                    <button class="btn btn-sm btn-action edit-blue" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalEdit{{ $u->UserID }}"
                                            title="Edit">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    
                                    <form action="{{ route('user.destroy', $u->UserID) }}" method="POST" class="d-inline ms-1">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-action delete" onclick="confirmDeleteUser(this)" title="Hapus">
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

<div class="modal fade" id="modalTambah" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.store') }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-primary mb-0"><i class="fas fa-user-plus me-2"></i>Tambah Akun Baru</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-start">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <input type="text" name="Username" class="form-control rounded-3" placeholder="Masukkan username" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Email Address</label>
                    <input type="email" name="Email" class="form-control rounded-3" placeholder="nama@email.com" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Password</label>
                    <input type="password" name="Password" class="form-control rounded-3" placeholder="Minimal 6 karakter" required>
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted">Role Akses</label>
                    <select name="Role" class="form-select rounded-3">
                        <option value="petugas">Petugas</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Daftarkan Akun</button>
            </div>
        </form>
    </div>
</div>

@foreach($users as $u)
<div class="modal fade" id="modalEdit{{ $u->UserID }}" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <form action="{{ route('user.update', $u->UserID) }}" method="POST" class="modal-content border-0 shadow-lg rounded-4">
            @csrf
            @method('PUT')
            <div class="modal-header border-0 pt-4 px-4">
                <h5 class="fw-bold text-primary mb-0"><i class="fas fa-user-edit me-2"></i>Edit Akun</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body p-4 text-start">
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Username</label>
                    <input type="text" name="Username" class="form-control rounded-3" value="{{ $u->Username }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Email Address</label>
                    <input type="email" name="Email" class="form-control rounded-3" value="{{ $u->Email }}" required>
                </div>
                <div class="mb-3">
                    <label class="form-label small fw-bold text-muted">Ganti Password <small class="fw-normal text-muted">(Kosongkan jika tidak diganti)</small></label>
                    <input type="password" name="Password" class="form-control rounded-3">
                </div>
                <div class="mb-2">
                    <label class="form-label small fw-bold text-muted">Role Akses</label>
                    <select name="Role" class="form-select rounded-3">
                        <option value="petugas" {{ $u->Role == 'petugas' ? 'selected' : '' }}>Petugas</option>
                        <option value="admin" {{ $u->Role == 'admin' ? 'selected' : '' }}>Admin</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer border-0 p-4 pt-0">
                <button type="submit" class="btn btn-primary w-100 py-2 fw-bold rounded-pill shadow-sm">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>
@endforeach

<style>
    .bg-soft-primary { background-color: #f0f7ff; }
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
    .btn-action:hover { transform: scale(1.1); filter: brightness(0.95); }
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.confirmDeleteUser = function(button) {
        Swal.fire({
            title: 'Hapus User?',
            text: "Akun ini tidak akan bisa login lagi setelah dihapus!",
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
            timer: 2000,
            showConfirmButton: false,
            borderRadius: '15px'
        });
    @endif
</script>
@endpush
@endsection