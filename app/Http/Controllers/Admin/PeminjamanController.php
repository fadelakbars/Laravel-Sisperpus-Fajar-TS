<?php

namespace App\Http\Controllers\Admin;

use App\Actions\Peminjaman\BuatPeminjaman;
use App\Actions\Peminjaman\ProsesPengembalianPeminjaman;
use App\Enums\PeranPengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\StorePeminjamanRequest;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    public function index(Request $request): View
    {
        $status = $request->string('status')->toString();

        $daftarPeminjaman = Peminjaman::query()
            ->with(['anggota', 'buku'])
            ->when($status !== '', fn (Builder $query) => $query->where('status_peminjaman', $status))
            ->latest('tanggal_pinjam')
            ->paginate(10)
            ->withQueryString();

        return view('admin.peminjaman.index', [
            'daftarPeminjaman' => $daftarPeminjaman,
            'status' => $status,
        ]);
    }

    public function create(): View
    {
        return view('admin.peminjaman.create', [
            'daftarAnggota' => User::query()
                ->where('peran', PeranPengguna::Anggota->value)
                ->orderBy('name')
                ->get(),
            'daftarBuku' => Buku::query()
                ->where('stok', '>', 0)
                ->orderBy('judul')
                ->get(),
        ]);
    }

    public function store(StorePeminjamanRequest $request, BuatPeminjaman $buatPeminjaman): RedirectResponse
    {
        $hasil = $buatPeminjaman($request->validated());
        $jumlah = count($hasil);

        return to_route('admin.peminjaman.index')
            ->with('status', "Berhasil mencatat {$jumlah} peminjaman buku.");
    }

    public function kembalikan(
        Peminjaman $peminjaman,
        ProsesPengembalianPeminjaman $prosesPengembalianPeminjaman,
    ): RedirectResponse {
        $prosesPengembalianPeminjaman($peminjaman);

        return to_route('admin.peminjaman.index')
            ->with('status', 'Pengembalian buku berhasil diproses.');
    }
}
