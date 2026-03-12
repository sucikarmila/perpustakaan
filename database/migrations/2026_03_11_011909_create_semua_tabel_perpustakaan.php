<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    // Tabel User (Modifikasi default Laravel)
    Schema::create('user', function (Blueprint $table) {
        $table->id('UserID');
        $table->string('Username')->unique();
        $table->string('Password');
        $table->string('Email')->unique();
        $table->string('NamaLengkap');
        $table->text('Alamat');
        $table->enum('Role', ['admin', 'petugas', 'peminjam']);
        $table->timestamps();
    });

    Schema::create('buku', function (Blueprint $table) {
        $table->id('BukuID');
        $table->string('Judul');
        $table->string('Penulis');
        $table->string('Penerbit');
        $table->integer('TahunTerbit');
        $table->timestamps();
    });

    Schema::create('kategoribuku', function (Blueprint $table) {
        $table->id('KategoriID');
        $table->string('NamaKategori');
        $table->timestamps();
    });

    Schema::create('kategoribuku_relasi', function (Blueprint $table) {
        $table->id('KategoriBukuID');
        $table->foreignId('BukuID')->constrained('buku', 'BukuID')->onDelete('cascade');
        $table->foreignId('KategoriID')->constrained('kategoribuku', 'KategoriID')->onDelete('cascade');
    });

    Schema::create('peminjaman', function (Blueprint $table) {
        $table->id('PeminjamanID');
        $table->foreignId('UserID')->constrained('user', 'UserID');
        $table->foreignId('BukuID')->constrained('buku', 'BukuID');
        $table->date('TanggalPeminjaman');
        $table->date('TanggalPengembalian')->nullable();
        $table->string('StatusPeminjaman', 50);
        $table->timestamps();
    });

    Schema::create('ulasanbuku', function (Blueprint $table) {
        $table->id('UlasanID');
        $table->foreignId('UserID')->constrained('user', 'UserID');
        $table->foreignId('BukuID')->constrained('buku', 'BukuID');
        $table->text('Ulasan');
        $table->integer('Rating');
    });

    Schema::create('koleksipribadi', function (Blueprint $table) {
        $table->id('KoleksiID');
        $table->foreignId('UserID')->constrained('user', 'UserID');
        $table->foreignId('BukuID')->constrained('buku', 'BukuID');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('semua_tabel_perpustakaan');
    }
};
