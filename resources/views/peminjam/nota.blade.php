<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Nota Peminjaman #{{ $p->PeminjamanID }}</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { font-family: 'Courier New', Courier, monospace; color: #333; }
        .receipt-card { max-width: 500px; margin: 30px auto; border: 1px dashed #ccc; padding: 20px; }
        .line { border-top: 1px dashed #000; margin: 10px 0; }
        @media print {
            .no-print { display: none; }
            .receipt-card { border: none; margin: 0; max-width: 100%; }
        }
    </style>
</head>
<body onload="window.print()">
    <div class="container">
        <div class="receipt-card">
            <div class="text-center mb-4">
                <h4 class="fw-bold mb-0">PERPUSTAKAAN DIGITAL</h4>
                <p class="small">Nota Resmi Pengembalian Buku</p>
            </div>

            <div class="d-flex justify-content-between small">
                <span>ID Transaksi: #{{ $p->PeminjamanID }}</span>
                <span>Tgl: {{ \Carbon\Carbon::now()->timezone('Asia/Jakarta')->format('d/m/Y H:i') }}</span>
            </div>
            
            <div class="line"></div>
            
            <div class="mb-3">
                <p class="mb-1 small"><strong>Peminjam:</strong> {{ $p->user->Username }}</p>
                <p class="mb-1 small"><strong>Buku:</strong> {{ $p->buku->Judul }}</p>
            </div>

            <table class="table table-borderless table-sm small">
                <tr>
                    <td>Tgl Pinjam</td>
                    <td class="text-end">{{ \Carbon\Carbon::parse($p->TanggalPeminjaman)->format('d/m/Y') }}</td>
                </tr>
                <tr>
                    <td>Tgl Kembali</td>
                    <td class="text-end">{{ \Carbon\Carbon::parse($p->TanggalPengembalian)->format('d/m/Y') }}</td>
                </tr>
                <tr class="fw-bold">
                    <td>Biaya Dasar</td>
                    <td class="text-end">Rp {{ number_format($p->BiayaTambahan, 0, ',', '.') }}</td>
                </tr>
                <tr class="text-danger">
                    <td>Denda (Keterlambatan/Rusak)</td>
                    <td class="text-end">+ Rp {{ number_format($p->Denda, 0, ',', '.') }}</td>
                </tr>
                <tr><td colspan="2"><div class="line"></div></td></tr>
                <tr class="fw-bold fs-5">
                    <td>TOTAL</td>
                    <td class="text-end">Rp {{ number_format($p->BiayaTambahan + $p->Denda, 0, ',', '.') }}</td>
                </tr>
            </table>

            <div class="text-center mt-4">
                <p class="small">Status: <strong>{{ strtoupper($p->StatusPeminjaman) }}</strong></p>
                <div class="line"></div>
                <p class="extra-small mt-2" style="font-size: 0.7rem;">Terima kasih telah membaca. Simpan nota ini sebagai bukti pengembalian yang sah.</p>
            </div>
        </div>

        <div class="text-center no-print mt-3">
            <button onclick="window.print()" class="btn btn-primary">Cetak Ulang</button>
            <a href="{{ route('riwayat') }}" class="btn btn-link">Kembali ke Riwayat</a>
        </div>
    </div>
</body>
</html>