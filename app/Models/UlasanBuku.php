<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UlasanBuku extends Model
{
    protected $table = 'ulasanbuku';
    protected $primaryKey = 'UlasanID';
    const CREATED_AT = 'created_at'; 
const UPDATED_AT = 'updated_at';
    protected $fillable = ['UserID', 'BukuID', 'Ulasan', 'Rating'];
    public $timestamps = false;  

    public function user() {
    return $this->belongsTo(User::class, 'UserID', 'UserID');
}
}