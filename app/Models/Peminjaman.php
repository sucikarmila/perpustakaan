<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';
    protected $primaryKey = 'PeminjamanID';
    
     protected $fillable = [
        'UserID', 
        'BukuID', 
        'TanggalPeminjaman', 
        'TanggalPengembalian', 
        'BiayaTambahan', 
        'Denda', 
        'StatusPeminjaman'
    ];

     
public function user() {
    return $this->belongsTo(User::class, 'UserID');
}

public function buku() {
    return $this->belongsTo(Buku::class, 'BukuID');
}
}