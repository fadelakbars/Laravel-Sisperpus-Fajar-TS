<?php

namespace App\Actions\Peminjaman;

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use Carbon\CarbonInterface;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ProsesPengembalianPeminjaman
{
    public function __invoke(Peminjaman $peminjaman, ?CarbonInterface $tanggalKembali = null): Peminjaman
    {
        return DB::transaction(function () use ($peminjaman, $tanggalKembali): Peminjaman {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->with('buku')
                ->findOrFail($peminjaman->id);

            if ($peminjaman->sudahDikembalikan()) {
                return $peminjaman;
            }

            /** @var Carbon $tanggalPengembalian */
            $tanggalPengembalian = $tanggalKembali ? Carbon::instance($tanggalKembali) : now();
            $buku = Buku::query()->lockForUpdate()->findOrFail($peminjaman->buku_id);

            $peminjaman->fill([
                'tanggal_kembali' => $tanggalPengembalian->toDateString(),
                'jumlah_denda' => $peminjaman->hitungJumlahDenda($tanggalPengembalian),
                'status_peminjaman' => StatusPeminjaman::Dikembalikan,
            ])->save();

            $buku->increment('stok');

            return $peminjaman->fresh(['anggota', 'buku']);
        });
    }
}
