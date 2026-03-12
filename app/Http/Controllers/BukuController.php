<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\KategoriBuku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BukuController extends Controller
{
    public function index()
    {
        $buku = Buku::with('kategori')->get();
        $kategori = KategoriBuku::all(); 
        return view('buku.index', compact('buku', 'kategori'));
    }

    public function generateLaporan(Request $request) { 
    $query = Peminjaman::with(['buku', 'user']);

    if ($request->filled('start_date')) {
        $query->whereDate('TanggalPeminjaman', '>=', $request->start_date);
    }
    if ($request->filled('end_date')) {
        $query->whereDate('TanggalPeminjaman', '<=', $request->end_date);
    }

    $laporan = $query->orderBy('TanggalPeminjaman', 'desc')->get();
    
    return view('buku.laporan', compact('laporan')); 
}
    public function store(Request $request) 
{
    try {
        $data = $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|integer',
            'KategoriID' => 'required',
            'Stok' => 'required|integer|min:0', 
            'Deskripsi' => 'nullable',
            'Gambar' => 'nullable|image|max:2048'
        ]);

        if ($request->hasFile('Gambar')) {
            $data['Gambar'] = $request->file('Gambar')->store('buku', 'public');
        }

        Buku::create($data); 
        return back()->with('success', 'Buku berhasil ditambah!');
    } catch (\Exception $e) {
        return dd($e->getMessage()); 
    }
}

    public function update(Request $request, $id) 
    {
        $buku = Buku::findOrFail($id);
        
        $request->validate([
            'Judul' => 'required',
            'Penulis' => 'required',
            'Penerbit' => 'required',
            'TahunTerbit' => 'required|integer',
            'KategoriID' => 'required',
            'Stok' => 'required|integer|min:0', 
            'Gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $data = $request->all();

        if ($request->hasFile('Gambar')) {
            if ($buku->Gambar) {
                Storage::disk('public')->delete($buku->Gambar);
            }
            $data['Gambar'] = $request->file('Gambar')->store('buku', 'public');
        }

        $buku->update($data);

        return back()->with('success', 'Data buku berhasil diperbarui!');
    }

    public function destroy($id) 
    {
        $buku = Buku::where('BukuID', $id)->firstOrFail();
        
        UlasanBuku::where('BukuID', $id)->delete();
        
        Peminjaman::where('BukuID', $id)->delete();

        if ($buku->Gambar) {
            Storage::disk('public')->delete($buku->Gambar);
        }
        
        $buku->delete();

        return back()->with('success', 'Buku dan data terkait berhasil dihapus!');
    }
}