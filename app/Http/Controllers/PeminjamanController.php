<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\UlasanBuku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PeminjamanController extends Controller
{
    public function index()
{
    $buku = Buku::with('ulasan')->get();
    $pinjaman = Peminjaman::with(['buku', 'user'])
                ->where('UserID', Auth::user()->UserID)
                ->get();

    return view('peminjam.index', compact('buku', 'pinjaman'));
}
    public function store(Request $request)
    {
        Peminjaman::create([
            'UserID' => Auth::user()->UserID,
            'BukuID' => $request->BukuID,
            'TanggalPeminjaman' => now(),
            'StatusPeminjaman' => 'Dipinjam'
        ]);

        return back()->with('success', 'Buku berhasil dipinjam!');
    }

     public function batalPinjam($id)
    {
        $pinjaman = Peminjaman::where('PeminjamanID', $id)
                    ->where('UserID', Auth::user()->UserID)
                    ->firstOrFail();
        $pinjaman->delete();

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }

     

    public function simpanUlasan(Request $request)
{
    $request->validate([
        'Ulasan' => 'required',
        'Rating' => 'required|integer|min:1|max:5',
    ]);

    UlasanBuku::create([
        'UserID' => Auth::user()->UserID,
        'BukuID' => $request->BukuID,
        'Ulasan' => $request->Ulasan,
        'Rating' => $request->Rating
    ]);

     return redirect('/pinjam-buku')->with('success', 'Terima kasih! Ulasan Anda telah diposting.');
}
    public function tulisUlasan($id) {
    $buku = \App\Models\Buku::findOrFail($id);
    return view('peminjam.tulis_ulasan', compact('buku'));
}


public function prosesPinjam(Request $request) {
    $buku = Buku::findOrFail($request->BukuID);

    if ($buku->Stok <= 0) {
        return back()->with('error', 'Maaf, stok buku ini sedang habis!');
    }

    $lama_pinjam = (int) $request->lama_pinjam; 
    
    Peminjaman::create([
        'UserID' => Auth::user()->UserID,
        'BukuID' => $request->BukuID,
        'TanggalPeminjaman' => now(),
        'TanggalPengembalian' => now()->addDays($lama_pinjam), 
        'StatusPeminjaman' => 'Menunggu Persetujuan' 
    ]);

    return redirect()->route('riwayat')->with('success', 'Permintaan peminjaman dikirim. Menunggu persetujuan admin.');
}

public function kembalikan(Request $request, $id) {
    $p = Peminjaman::findOrFail($id);
    
    $p->update([
        'StatusPeminjaman' => 'Menunggu Konfirmasi Kembali',
        'Denda' => $request->denda_rusak ?? 0 
    ]);

    return back()->with('success', 'Permintaan pengembalian dikirim. Silakan serahkan buku ke petugas.');
}


public function konfirmasiIndex() {
    $peminjaman = Peminjaman::with(['buku', 'user'])
        ->whereIn('StatusPeminjaman', ['Menunggu Persetujuan', 'Menunggu Konfirmasi Kembali'])
        ->get();
    return view('admin.konfirmasi', compact('peminjaman'));
}

public function setujuiPinjam($id) {
    $p = Peminjaman::findOrFail($id);
    $buku = Buku::where('BukuID', $p->BukuID)->first();

    if ($buku->Stok <= 0) {
        return back()->with('error', 'Gagal! Stok buku sudah habis saat akan disetujui.');
    }

    $p->update(['StatusPeminjaman' => 'Dipinjam']);
    $buku->decrement('Stok');

    return back()->with('success', 'Peminjaman telah aktif!');
}

public function setujuiKembali($id) {
    $p = Peminjaman::findOrFail($id);
    
    $tgl_kembali_seharusnya = \Carbon\Carbon::parse($p->TanggalPengembalian);
    $denda_telat = 0;
    if (now() > $tgl_kembali_seharusnya) {
        $denda_telat = now()->diffInDays($tgl_kembali_seharusnya) * 1000;
    }

    $p->update([
        'StatusPeminjaman' => 'Dikembalikan',
        'Denda' => $p->Denda + $denda_telat 
    ]);

    $p->buku->increment('Stok'); 

    return back()->with('success', 'Buku telah diterima dan dikembalikan ke stok.');
} 
public function tolakPinjam($id) {
    $p = Peminjaman::findOrFail($id);
    
    $p->delete();

    return back()->with('success', 'Permintaan peminjaman berhasil ditolak.');
}
public function riwayat()
{
     $pinjaman = Peminjaman::with(['buku'])
                ->where('UserID', Auth::user()->UserID)
                ->orderBy('created_at', 'desc')
                ->get();

    return view('peminjam.riwayat', compact('pinjaman'));
}
public function showForm($id) {
    $buku = Buku::findOrFail($id);
    return view('peminjam.form_pinjam', compact('buku'));
}
public function cetakNota($id)
{
    $p = Peminjaman::with(['buku', 'user'])
                   ->where('PeminjamanID', $id)
                   ->where('UserID', Auth::user()->UserID)
                   ->firstOrFail();

    return view('peminjam.nota', compact('p'));
}
}
