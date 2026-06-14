<?php

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dapat membuat peminjaman sekaligus beberapa buku dan stok buku berkurang', function () {
    $this->withoutMiddleware();
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();
    $buku1 = Buku::factory()->create(['stok' => 3]);
    $buku2 = Buku::factory()->create(['stok' => 5]);

    $response = $this->actingAs($admin)->post(route('admin.peminjaman.store'), [
        'anggota_id' => $anggota->id,
        'buku_ids' => [$buku1->id, $buku2->id],
        'tanggal_pinjam' => '2026-06-14',
        'tanggal_jatuh_tempo' => '2026-06-21',
    ]);

    $response->assertRedirect(route('admin.peminjaman.index'));
    $response->assertSessionHas('status', 'Berhasil mencatat 2 peminjaman buku.');

    expect(Peminjaman::query()->count())->toBe(2);
    expect($buku1->fresh()->stok)->toBe(2);
    expect($buku2->fresh()->stok)->toBe(4);
});

test('admin tidak dapat meminjamkan buku jika ada salah satu buku stok habis', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();
    $bukuOk = Buku::factory()->create(['stok' => 3]);
    $bukuHabis = Buku::factory()->create(['stok' => 0]);

    $response = $this->actingAs($admin)->from(route('admin.peminjaman.create'))->post(route('admin.peminjaman.store'), [
        'anggota_id' => $anggota->id,
        'buku_ids' => [$bukuOk->id, $bukuHabis->id],
        'tanggal_pinjam' => '2026-06-14',
        'tanggal_jatuh_tempo' => '2026-06-21',
    ]);

    $response->assertRedirect(route('admin.peminjaman.create'));
    $response->assertSessionHasErrors('buku_ids');
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
