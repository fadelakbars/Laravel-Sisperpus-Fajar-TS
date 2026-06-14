<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $riwayatPeminjaman = Peminjaman::query()
            ->with('buku')
            ->whereBelongsTo($request->user(), 'anggota')
            ->latest('tanggal_pinjam')
            ->paginate(10);

        return view('anggota.dashboard', [
            'riwayatPeminjaman' => $riwayatPeminjaman,
        ]);
    }

    public function cetakSuratBebas(Request $request): View
    {
        if (!$request->user()->bisaDownloadSuratBebas()) {
            abort(403, 'Anda belum memenuhi syarat untuk mendapatkan Surat Bebas Perpustakaan.');
        }

        return view('anggota.surat-bebas', [
            'user' => $request->user(),
            'tanggal' => now(),
        ]);
    }
}
