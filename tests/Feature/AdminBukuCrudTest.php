<?php

use App\Models\Buku;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

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
    Storage::fake('public');

    $response = $this->actingAs($admin)->post(route('admin.buku.store'), [
        'isbn' => '9786020000001',
        'judul' => 'Arsitektur Aplikasi Web',
        'penulis' => 'Tono Prakasa',
        'penerbit' => 'Kampus Press',
        'tahun_terbit' => 2024,
        'stok' => 7,
        'lokasi_rak' => 'Rak D-1',
        'gambar_sampul' => UploadedFile::fake()->image('arsitektur-web.jpg'),
    ]);

    $response->assertRedirect(route('admin.buku.index'));
    $this->assertDatabaseHas('buku', [
        'isbn' => '9786020000001',
        'judul' => 'Arsitektur Aplikasi Web',
    ]);

    $buku = Buku::query()->where('isbn', '9786020000001')->firstOrFail();
    expect($buku->gambar_sampul)->not->toBeNull();
    Storage::disk('public')->assertExists($buku->gambar_sampul);
});

test('admin dapat memperbarui buku', function () {
    $admin = User::factory()->admin()->create();
    Storage::fake('public');
    $gambarLama = UploadedFile::fake()->image('lama.jpg')->store('gambar-sampul-buku', 'public');
    $buku = Buku::factory()->create([
        'judul' => 'Laravel Lama',
        'stok' => 2,
        'gambar_sampul' => $gambarLama,
    ]);

    $response = $this->actingAs($admin)->put(route('admin.buku.update', $buku), [
        'isbn' => $buku->isbn,
        'judul' => 'Laravel Baru',
        'penulis' => $buku->penulis,
        'penerbit' => $buku->penerbit,
        'tahun_terbit' => $buku->tahun_terbit,
        'stok' => 9,
        'lokasi_rak' => $buku->lokasi_rak,
        'gambar_sampul' => UploadedFile::fake()->image('baru.jpg'),
    ]);

    $response->assertRedirect(route('admin.buku.index'));

    expect($buku->fresh())
        ->judul->toBe('Laravel Baru')
        ->stok->toBe(9);

    expect($buku->fresh()->gambar_sampul)->not->toBe($gambarLama);
    Storage::disk('public')->assertMissing($gambarLama);
    Storage::disk('public')->assertExists($buku->fresh()->gambar_sampul);
});

test('admin dapat menghapus buku', function () {
    $admin = User::factory()->admin()->create();
    Storage::fake('public');
    $gambarSampul = UploadedFile::fake()->image('hapus.jpg')->store('gambar-sampul-buku', 'public');
    $buku = Buku::factory()->create([
        'gambar_sampul' => $gambarSampul,
    ]);

    $response = $this->actingAs($admin)
        ->delete(route('admin.buku.destroy', $buku));

    $response->assertRedirect(route('admin.buku.index'));
    $this->assertModelMissing($buku);
    Storage::disk('public')->assertMissing($gambarSampul);
});

test('anggota tidak dapat mengakses manajemen buku admin', function () {
    $anggota = User::factory()->anggota()->create();

    $this->actingAs($anggota)
        ->get(route('admin.buku.index'))
        ->assertForbidden();
});
