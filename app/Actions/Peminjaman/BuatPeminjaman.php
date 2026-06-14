<?php

namespace App\Actions\Peminjaman;

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class BuatPeminjaman
{
    /**
     * @param  array<string, mixed>  $data
     * @return array<int, Peminjaman>
     */
    public function __invoke(array $data): array
    {
        return DB::transaction(function () use ($data): array {
            $hasilPeminjaman = [];
            $bukuIds = (array) $data['buku_ids'];

            foreach ($bukuIds as $bukuId) {
                $buku = Buku::query()->lockForUpdate()->findOrFail($bukuId);

                if ($buku->stok < 1) {
                    throw ValidationException::withMessages([
                        'buku_ids' => "Buku '{$buku->judul}' sedang tidak tersedia.",
                    ]);
                }

                $peminjaman = Peminjaman::query()->create([
                    'anggota_id' => $data['anggota_id'],
                    'buku_id' => $buku->id,
                    'tanggal_pinjam' => $data['tanggal_pinjam'],
                    'tanggal_jatuh_tempo' => $data['tanggal_jatuh_tempo'],
                    'jumlah_denda' => 0,
                    'status_peminjaman' => StatusPeminjaman::Dipinjam,
                ]);

                $buku->decrement('stok');
                $hasilPeminjaman[] = $peminjaman->fresh(['anggota', 'buku']);
            }

            return $hasilPeminjaman;
        });
    }
}
