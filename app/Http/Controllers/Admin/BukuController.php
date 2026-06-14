<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreBukuRequest;
use App\Http\Requests\UpdateBukuRequest;
use App\Models\Buku;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
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
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.buku.index', [
            'daftarBuku' => $daftarBuku,
            'kataKunci' => $kataKunci,
        ]);
    }

    public function create(): View
    {
        return view('admin.buku.create');
    }

    public function store(StoreBukuRequest $request): RedirectResponse
    {
        Buku::query()->create($request->validated());

        return to_route('admin.buku.index')
            ->with('status', 'Data buku berhasil ditambahkan.');
    }

    public function edit(Buku $buku): View
    {
        return view('admin.buku.edit', ['buku' => $buku]);
    }

    public function update(UpdateBukuRequest $request, Buku $buku): RedirectResponse
    {
        $buku->update($request->validated());

        return to_route('admin.buku.index')
            ->with('status', 'Data buku berhasil diperbarui.');
    }

    public function destroy(Buku $buku): RedirectResponse
    {
        $buku->delete();

        return to_route('admin.buku.index')
            ->with('status', 'Data buku berhasil dihapus.');
    }
}
