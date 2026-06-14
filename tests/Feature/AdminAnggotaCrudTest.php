<?php

use App\Enums\PeranPengguna;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dapat melihat daftar anggota', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create(['name' => 'Mahasiswa A']);

    $this->actingAs($admin)
        ->get(route('admin.anggota.index'))
        ->assertSuccessful()
        ->assertSee('Mahasiswa A');
});

test('admin dapat menambahkan anggota baru', function () {
    $admin = User::factory()->admin()->create();

    $response = $this->actingAs($admin)->post(route('admin.anggota.store'), [
        'name' => 'Anggota Baru',
        'email' => 'anggota-baru@example.com',
        'nim' => '2300000099',
        'password' => 'password123',
        'password_confirmation' => 'password123',
    ]);

    $response->assertRedirect(route('admin.anggota.index'));
    $this->assertDatabaseHas('users', [
        'email' => 'anggota-baru@example.com',
        'peran' => PeranPengguna::Anggota->value,
    ]);
});

test('admin dapat memperbarui anggota', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create([
        'name' => 'Nama Lama',
        'email' => 'lama@example.com',
        'nim' => '2300000011',
    ]);

    $response = $this->actingAs($admin)->put(route('admin.anggota.update', $anggota), [
        'name' => 'Nama Baru',
        'email' => 'baru@example.com',
        'nim' => '2300000012',
        'password' => '',
        'password_confirmation' => '',
    ]);

    $response->assertRedirect(route('admin.anggota.index'));

    expect($anggota->fresh())
        ->name->toBe('Nama Baru')
        ->email->toBe('baru@example.com')
        ->nim->toBe('2300000012');
});

test('admin dapat menghapus anggota', function () {
    $admin = User::factory()->admin()->create();
    $anggota = User::factory()->anggota()->create();

    $response = $this->actingAs($admin)
        ->delete(route('admin.anggota.destroy', $anggota));

    $response->assertRedirect(route('admin.anggota.index'));
    $this->assertModelMissing($anggota);
});

test('anggota tidak dapat mengakses manajemen anggota admin', function () {
    $anggota = User::factory()->anggota()->create();

    $this->actingAs($anggota)
        ->get(route('admin.anggota.index'))
        ->assertForbidden();
});
