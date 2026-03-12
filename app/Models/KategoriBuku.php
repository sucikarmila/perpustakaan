<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class KategoriBuku extends Model
{
    protected $table = 'kategoribuku';
protected $primaryKey = 'KategoriID';
protected $fillable = ['NamaKategori'];
public function buku()
{
     return $this->hasMany(Buku::class, 'KategoriID', 'KategoriID');
}
}
