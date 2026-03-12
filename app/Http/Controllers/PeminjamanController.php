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
    $biaya_tambahan = $lama_pinjam > 7 ? 5000 : 0;
    
    Peminjaman::create([
        'UserID' => Auth::user()->UserID,
        'BukuID' => $request->BukuID,
        'TanggalPeminjaman' => now(),
        'TanggalPengembalian' => now()->addDays($lama_pinjam), 
        'BiayaTambahan' => $biaya_tambahan,
        'StatusPeminjaman' => 'Dipinjam'
    ]);

     $buku->decrement('Stok');

    return redirect()->route('riwayat')->with('success', 'Buku berhasil dipinjam!');
}

public function kembalikan(Request $request, $id) {
    $p = Peminjaman::findOrFail($id);
    
    if ($p->StatusPeminjaman == 'Dikembalikan') {
        return back();
    }

    $tgl_kembali_seharusnya = \Carbon\Carbon::parse($p->TanggalPengembalian);
    $denda_telat = 0;
    if (now() > $tgl_kembali_seharusnya) {
        $denda_telat = now()->diffInDays($tgl_kembali_seharusnya) * 1000;
    }

    $p->update([
        'Denda' => $denda_telat + ($request->denda_rusak ?? 0),
        'StatusPeminjaman' => 'Dikembalikan'
    ]);

     $p->buku->increment('Stok');

    return back()->with('success', 'Buku dikembalikan!');
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
