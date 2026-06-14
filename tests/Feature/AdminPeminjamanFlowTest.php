<?php

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dapat membuat peminjaman dan stok buku berkurang', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();
    $buku = Buku::factory()->create(['stok' => 3]);

    $response = $this->actingAs($admin)->post(route('admin.peminjaman.store'), [
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => '2026-06-14',
        'tanggal_jatuh_tempo' => '2026-06-21',
    ]);

    $response->assertRedirect(route('admin.peminjaman.index'));

    $peminjaman = Peminjaman::query()->first();

    expect($peminjaman)
        ->not->toBeNull()
        ->status_peminjaman->toBe(StatusPeminjaman::Dipinjam);

    expect($buku->fresh()->stok)->toBe(2);
});

test('admin tidak dapat meminjamkan buku jika stok habis', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();
    $buku = Buku::factory()->create(['stok' => 0]);

    $response = $this->actingAs($admin)->from(route('admin.peminjaman.create'))->post(route('admin.peminjaman.store'), [
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => '2026-06-14',
        'tanggal_jatuh_tempo' => '2026-06-21',
    ]);

    $response->assertRedirect(route('admin.peminjaman.create'));
    $response->assertSessionHasErrors('buku_id');
    expect(Peminjaman::query()->count())->toBe(0);
});

test('admin dapat memproses pengembalian dan stok buku bertambah kembali', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();
    $buku = Buku::factory()->create(['stok' => 1]);
    $peminjaman = Peminjaman::factory()->create([
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'tanggal_pinjam' => '2026-06-01',
        'tanggal_jatuh_tempo' => '2026-06-08',
        'tanggal_kembali' => null,
        'jumlah_denda' => 0,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    $response = $this->actingAs($admin)
        ->patch(route('admin.peminjaman.kembalikan', $peminjaman));

    $response->assertRedirect(route('admin.peminjaman.index'));

    expect($peminjaman->fresh())
        ->status_peminjaman->toBe(StatusPeminjaman::Dikembalikan)
        ->tanggal_kembali->not->toBeNull();

    expect($buku->fresh()->stok)->toBe(2);
});

test('anggota tidak dapat mengakses modul peminjaman admin', function () {
    $anggota = User::factory()->anggota()->create();

    $this->actingAs($anggota)
        ->get(route('admin.peminjaman.index'))
        ->assertForbidden();
});
