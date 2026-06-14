<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $kataKunci = $request->string('cari')->toString();

        $daftarBuku = Buku::query()
            ->when($kataKunci !== '', function (Builder $query) use ($kataKunci): void {
                $query->where(function (Builder $subQuery) use ($kataKunci): void {
                    $subQuery
                        ->where('judul', 'like', "%{$kataKunci}%")
                        ->orWhere('penulis', 'like', "%{$kataKunci}%")
                        ->orWhere('penerbit', 'like', "%{$kataKunci}%")
                        ->orWhere('isbn', 'like', "%{$kataKunci}%");
                });
            })
            ->orderBy('judul')
            ->paginate(8, ['*'], 'halaman_buku')
            ->withQueryString();

        $riwayatPeminjaman = Peminjaman::query()
            ->with('buku')
            ->whereBelongsTo($request->user(), 'anggota')
            ->latest('tanggal_pinjam')
            ->paginate(8, ['*'], 'halaman_peminjaman')
            ->withQueryString();

        return view('anggota.dashboard', [
            'daftarBuku' => $daftarBuku,
            'riwayatPeminjaman' => $riwayatPeminjaman,
            'kataKunci' => $kataKunci,
        ]);
    }
}
