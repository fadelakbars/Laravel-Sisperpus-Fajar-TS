<?php

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('anggota dapat melihat katalog buku dan riwayat peminjamannya sendiri', function () {
    $anggota = User::factory()->anggota()->create();
    $anggotaLain = User::factory()->anggota()->create();

    $bukuPertama = Buku::factory()->create([
        'judul' => 'Laravel Praktis',
        'gambar_sampul' => 'image/Pengantar_Ilmu_Komputer.webp',
    ]);
    $bukuKedua = Buku::factory()->create(['judul' => 'Pemrograman Web Modern']);
    $bukuKetiga = Buku::factory()->create(['judul' => 'Basis Data Lanjut']);

    Peminjaman::factory()->create([
        'anggota_id' => $anggota->id,
        'buku_id' => $bukuPertama->id,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    Peminjaman::factory()->create([
        'anggota_id' => $anggotaLain->id,
        'buku_id' => $bukuKedua->id,
        'status_peminjaman' => StatusPeminjaman::Terlambat,
    ]);

    $response = $this->actingAs($anggota)
        ->get(route('anggota.dashboard'));

    $response->assertSuccessful();
    $response->assertSee('Laravel Praktis');
    $response->assertSee('Pemrograman Web Modern');
    $response->assertSee('Basis Data Lanjut');
    $response->assertSee($anggota->nim);
    $response->assertDontSee($anggotaLain->nim);
    $response->assertSee('image/Pengantar_Ilmu_Komputer.webp');
});

test('anggota dapat mencari buku dari dashboard', function () {
    $anggota = User::factory()->anggota()->create();
    Buku::factory()->create(['judul' => 'Laravel Tingkat Lanjut']);
    Buku::factory()->create(['judul' => 'Manajemen Proyek TI']);

    $response = $this->actingAs($anggota)
        ->get(route('anggota.dashboard', ['cari' => 'Laravel']));

    $response->assertSuccessful();
    $response->assertSee('Laravel Tingkat Lanjut');
    $response->assertDontSee('Manajemen Proyek TI');
});

test('admin tidak dapat mengakses dashboard anggota', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('anggota.dashboard'))
        ->assertForbidden();
});
