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
}
