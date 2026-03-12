<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buku extends Model
{
    protected $table = 'buku';
protected $primaryKey = 'BukuID';
protected $fillable = [
    'Judul', 
    'Penulis', 
    'Penerbit', 
    'TahunTerbit', 
    'KategoriID', 
    'Stok', 
    'Deskripsi', 
    'Gambar'
];
public function ulasan()
{
    return $this->hasMany(UlasanBuku::class, 'BukuID', 'BukuID');
}
public function kategori()
{
    return $this->belongsTo(KategoriBuku::class, 'KategoriID', 'KategoriID');
}
}
