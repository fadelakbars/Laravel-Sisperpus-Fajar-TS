<?php

namespace App\Http\Controllers\Anggota;

use App\Http\Controllers\Controller;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BukuController extends Controller
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
            ->paginate(12)
            ->withQueryString();

        return view('anggota.buku.index', [
            'daftarBuku' => $daftarBuku,
            'kataKunci' => $kataKunci,
        ]);
    }
}
