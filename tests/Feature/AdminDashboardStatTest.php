<?php

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('dashboard admin menampilkan statistik aktual', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->count(3)->create();
    $buku = Buku::factory()->count(4)->create();

    Peminjaman::factory()->count(2)->create([
        'anggota_id' => $anggota->first()->id,
        'buku_id' => $buku->first()->id,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    Peminjaman::factory()->create([
        'anggota_id' => $anggota->get(1)->id,
        'buku_id' => $buku->get(1)->id,
        'status_peminjaman' => StatusPeminjaman::Terlambat,
        'tanggal_kembali' => null,
        'jumlah_denda' => 4000,
    ]);

    Peminjaman::factory()->create([
        'anggota_id' => $anggota->last()->id,
        'buku_id' => $buku->last()->id,
        'status_peminjaman' => StatusPeminjaman::Dikembalikan,
    ]);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertSuccessful();
    $response->assertViewHas('statistik', [
        'total_buku' => 4,
        'total_anggota' => 3,
        'total_dipinjam' => 2,
        'total_terlambat' => 1,
    ]);
    $response->assertSeeTextInOrder([
        'Total Buku',
        '4',
        'Total Anggota',
        '3',
        'Dipinjam',
        '2',
        'Terlambat',
        '1',
    ]);
});
