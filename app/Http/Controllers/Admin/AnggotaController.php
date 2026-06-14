<?php

namespace App\Http\Controllers\Admin;

use App\Enums\PeranPengguna;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AnggotaController extends Controller
{
    public function index(Request $request): View
    {
        $kataKunci = $request->string('cari')->toString();

        $daftarAnggota = User::query()
            ->where('peran', PeranPengguna::Anggota->value)
            ->when($kataKunci !== '', function (Builder $query) use ($kataKunci): void {
                $query->where(function (Builder $subQuery) use ($kataKunci): void {
                    $subQuery
                        ->where('name', 'like', "%{$kataKunci}%")
                        ->orWhere('email', 'like', "%{$kataKunci}%")
                        ->orWhere('nim', 'like', "%{$kataKunci}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.anggota.index', [
            'daftarAnggota' => $daftarAnggota,
            'kataKunci' => $kataKunci,
        ]);
    }

    public function create(): View
    {
        return view('admin.anggota.create');
    }

    public function store(StoreUserRequest $request): RedirectResponse
    {
        User::query()->create($request->validated() + [
            'peran' => PeranPengguna::Anggota,
        ]);

        return to_route('admin.anggota.index')
            ->with('status', 'Data anggota berhasil ditambahkan.');
    }

    public function edit(User $anggota): View
    {
        abort_unless($anggota->adalahAnggota(), 404);

        return view('admin.anggota.edit', ['anggota' => $anggota]);
    }

    public function update(UpdateUserRequest $request, User $anggota): RedirectResponse
    {
        abort_unless($anggota->adalahAnggota(), 404);

        $data = $request->validated();

        if (blank($data['password'] ?? null)) {
            unset($data['password']);
        }

        $anggota->update($data);

        return to_route('admin.anggota.index')
            ->with('status', 'Data anggota berhasil diperbarui.');
    }

    public function destroy(User $anggota): RedirectResponse
    {
        abort_unless($anggota->adalahAnggota(), 404);

        $anggota->delete();

        return to_route('admin.anggota.index')
            ->with('status', 'Data anggota berhasil dihapus.');
    }
}
