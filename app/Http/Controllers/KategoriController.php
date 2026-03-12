<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriBuku; 
class KategoriController extends Controller
{
    public function index()
{
    $kategori = \App\Models\KategoriBuku::with('buku')->withCount('buku')->get();
    return view('kategori.index', compact('kategori'));
}

public function store(Request $request) {
    KategoriBuku::create($request->all());
    return back()->with('success', 'Kategori berhasil ditambah!');
}
public function update(Request $request, $id) {
    $kategori = KategoriBuku::findOrFail($id);
    $kategori->update($request->all());
    return back()->with('success', 'Kategori diupdate!');
}

public function destroy($id)
{
    $kategori = KategoriBuku::findOrFail($id);

    if ($kategori->buku()->count() > 0) {
        return back()->with('error', 'Gagal menghapus! Kategori ini masih memiliki koleksi buku. Hapus atau pindahkan buku terlebih dahulu.');
    }

    $kategori->delete();
    return back()->with('success', 'Kategori berhasil dihapus!');
}

public function show($id) {
    $kategori = KategoriBuku::findOrFail($id);
    $buku = Buku::where('KategoriID', $id)->get(); 
    return view('kategori.show', compact('kategori', 'buku'));
}
}
