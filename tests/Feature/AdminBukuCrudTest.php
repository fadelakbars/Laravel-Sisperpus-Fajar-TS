<?php

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dapat melihat daftar buku', function () {
    $admin = User::factory()->admin()->create();
    $buku = Buku::factory()->create(['judul' => 'Pengantar Laravel']);

    $this->actingAs($admin)
        ->get(route('admin.buku.index'))
        ->assertSuccessful()
        ->assertSee('Pengantar Laravel');
});

test('admin dapat menambahkan buku baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('admin.buku.store'), [
        'isbn' => '9786020000001',
        'judul' => 'Arsitektur Aplikasi Web',
        'penulis' => 'Tono Prakasa',
        'penerbit' => 'Kampus Press',
        'tahun_terbit' => 2024,
        'stok' => 7,
        'lokasi_rak' => 'Rak D-1',
    ]);

    $response->assertRedirect(route('admin.buku.index'));
    $this->assertDatabaseHas('buku', [
        'isbn' => '9786020000001',
        'judul' => 'Arsitektur Aplikasi Web',
    ]);
});

test('admin dapat memperbarui buku', function () {
    $admin = User::factory()->admin()->create();
    $buku = Buku::factory()->create([
        'judul' => 'Laravel Lama',
        'stok' => 2,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.buku.update', $buku), [
        'isbn' => $buku->isbn,
        'judul' => 'Laravel Baru',
        'penulis' => $buku->penulis,
        'penerbit' => $buku->penerbit,
        'tahun_terbit' => $buku->tahun_terbit,
        'stok' => 9,
        'lokasi_rak' => $buku->lokasi_rak,
    ]);

    $response->assertRedirect(route('admin.buku.index'));

    expect($buku->fresh())
        ->judul->toBe('Laravel Baru')
        ->stok->toBe(9);
});

test('admin dapat menghapus buku', function () {
    $admin = User::factory()->admin()->create();
    $buku = Buku::factory()->create();

    $response = $this->actingAs($admin)
        ->delete(route('admin.buku.destroy', $buku));

    $response->assertRedirect(route('admin.buku.index'));
    $this->assertModelMissing($buku);
});

test('anggota tidak dapat mengakses manajemen buku admin', function () {
    $anggota = User::factory()->anggota()->create();

    $this->actingAs($anggota)
        ->get(route('admin.buku.index'))
        ->assertForbidden();
});
