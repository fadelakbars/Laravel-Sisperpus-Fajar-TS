<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeranPengguna;
use App\Enums\StatusPeminjaman;
use App\Http\Controllers\Controller;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __invoke(): View
    {
        return view('admin.dashboard', [
            'statistik' => [
                'total_buku' => Buku::query()->count(),
                'total_anggota' => User::query()
                    ->where('peran', PeranPengguna::Anggota)
                    ->count(),
                'total_dipinjam' => Peminjaman::query()
                    ->where('status_peminjaman', StatusPeminjaman::Dipinjam)
                    ->count(),
                'total_terlambat' => Peminjaman::query()
                    ->where('status_peminjaman', StatusPeminjaman::Terlambat)
                    ->count(),
            ],
        ]);
    }
}
