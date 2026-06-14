<?php

use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Carbon\CarbonImmutable;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

afterEach(function () {
    CarbonImmutable::setTestNow();
});

test('command memperbarui peminjaman aktif yang sudah melewati jatuh tempo', function () {
    CarbonImmutable::setTestNow('2026-06-14 09:00:00');

    $peminjaman = Peminjaman::factory()->create([
        'tanggal_pinjam' => '2026-06-01',
        'tanggal_jatuh_tempo' => '2026-06-10',
        'tanggal_kembali' => null,
        'jumlah_denda' => 0,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    $this->artisan('app:perbarui-status-peminjaman-terlambat')
        ->expectsOutput('1 peminjaman diperbarui menjadi terlambat.')
        ->assertSuccessful();

    expect($peminjaman->fresh())
        ->status_peminjaman->toBe(StatusPeminjaman::Terlambat)
        ->jumlah_denda->toBe('8000.00');
});

test('command mengabaikan peminjaman yang belum jatuh tempo atau sudah dikembalikan', function () {
    CarbonImmutable::setTestNow('2026-06-14 09:00:00');

    $belumJatuhTempo = Peminjaman::factory()->create([
        'tanggal_pinjam' => '2026-06-12',
        'tanggal_jatuh_tempo' => '2026-06-18',
        'tanggal_kembali' => null,
        'jumlah_denda' => 0,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    $sudahDikembalikan = Peminjaman::factory()->create([
        'tanggal_pinjam' => '2026-06-01',
        'tanggal_jatuh_tempo' => '2026-06-08',
        'tanggal_kembali' => '2026-06-09',
        'jumlah_denda' => 2000,
        'status_peminjaman' => StatusPeminjaman::Dikembalikan,
    ]);

    $this->artisan('app:perbarui-status-peminjaman-terlambat')
        ->expectsOutput('0 peminjaman diperbarui menjadi terlambat.')
        ->assertSuccessful();

    expect($belumJatuhTempo->fresh())
        ->status_peminjaman->toBe(StatusPeminjaman::Dipinjam)
        ->jumlah_denda->toBe('0.00');

    expect($sudahDikembalikan->fresh())
        ->status_peminjaman->toBe(StatusPeminjaman::Dikembalikan)
        ->jumlah_denda->toBe('2000.00');
});
