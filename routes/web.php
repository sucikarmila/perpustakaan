<?php
use App\Http\Controllers\AuthController;
use App\Http\Controllers\BukuController;
use App\Http\Controllers\PeminjamanController;
use App\Http\Controllers\KategoriController; 
Route::get('/', [AuthController::class, 'showLogin']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/dashboard', function () {
    return view('dashboard');
});
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::middleware('role:admin,petugas')->group(function () {
        Route::resource('buku', BukuController::class);
        Route::get('/laporan', [BukuController::class, 'generateLaporan']);
    });

    Route::middleware('role:admin')->group(function () {
        Route::get('/user-management', [AuthController::class, 'index']);
    });

    Route::get('/user-management', [AuthController::class, 'index'])->name('user.index');
    Route::post('/user-management', [AuthController::class, 'storePetugas'])->name('user.store');
    Route::delete('/user-management/{id}', [AuthController::class, 'destroy'])->name('user.destroy');
    Route::put('/user-management/{id}', [AuthController::class, 'update'])->name('user.update');
    Route::middleware('role:peminjam')->group(function () {
        Route::get('/pinjam-buku', [PeminjamanController::class, 'index']);
        Route::post('/pinjam-buku', [PeminjamanController::class, 'store']);
    });
    Route::resource('kategori', KategoriController::class);

    Route::post('/batal-pinjam/{id}', [PeminjamanController::class, 'batalPinjam']);
    Route::post('/simpan-ulasan', [PeminjamanController::class, 'simpanUlasan']);
    Route::post('/kembalikan-buku/{id}', [PeminjamanController::class, 'kembalikan']);

    Route::get('/ulasan/{id}', [PeminjamanController::class, 'tulisUlasan'])->name('ulasan.tulis');
Route::post('/ulasan/simpan', [PeminjamanController::class, 'simpanUlasan'])->name('ulasan.simpan');

Route::get('/pinjam/form/{id}', [PeminjamanController::class, 'showForm'])->name('pinjam.form');
Route::post('/pinjam/proses', [PeminjamanController::class, 'prosesPinjam'])->name('pinjam.proses');
Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat');
Route::get('/nota/{id}', [PeminjamanController::class, 'cetakNota'])->name('nota');

Route::get('/nota/{id}', function($id) {
    $p = \App\Models\Peminjaman::with(['buku', 'user'])->findOrFail($id);
    return view('peminjam.nota', compact('p'));
})->name('nota');
Route::delete('/kategori/{id}', [KategoriController::class, 'destroy']);
Route::put('/kategori/{id}', [KategoriController::class, 'update']);
});