<?php

namespace App\Console\Commands;

use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Carbon\CarbonImmutable;
use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

#[Signature('app:perbarui-status-peminjaman-terlambat')]
#[Description('Memperbarui status peminjaman yang melewati tanggal jatuh tempo')]
class PerbaruiStatusPeminjamanTerlambat extends Command
{
    public function handle(): int
    {
        $tanggalHariIni = CarbonImmutable::today();

        $peminjamanTerlambat = Peminjaman::query()
            ->belumDikembalikan()
            ->whereDate('tanggal_jatuh_tempo', '<', $tanggalHariIni)
            ->get();

        foreach ($peminjamanTerlambat as $peminjaman) {
            $peminjaman->forceFill([
                'status_peminjaman' => StatusPeminjaman::Terlambat,
                'jumlah_denda' => $peminjaman->hitungJumlahDenda($tanggalHariIni),
            ])->save();
        }

        $this->info("{$peminjamanTerlambat->count()} peminjaman diperbarui menjadi terlambat.");

        return self::SUCCESS;
    }
}
