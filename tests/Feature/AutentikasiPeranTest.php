<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('admin dapat login dan diarahkan ke dashboard admin', function () {
    $admin = User::factory()->admin()->create([
        'email' => 'admin@example.com',
    ]);

    $response = $this->post('/login', [
        'email' => 'admin@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticatedAs($admin);
});

test('anggota dapat login dan diarahkan ke dashboard anggota', function () {
    $anggota = User::factory()->anggota()->create([
        'email' => 'anggota@example.com',
    ]);

    $response = $this->post('/login', [
        'email' => 'anggota@example.com',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('anggota.dashboard'));
    $this->assertAuthenticatedAs($anggota);
});

test('admin tidak dapat mengakses dashboard anggota', function () {
    $admin = User::factory()->admin()->create();

    $this->actingAs($admin)
        ->get(route('anggota.dashboard'))
        ->assertForbidden();
});

test('anggota tidak dapat mengakses dashboard admin', function () {
    $anggota = User::factory()->anggota()->create();

    $this->actingAs($anggota)
        ->get(route('admin.dashboard'))
        ->assertForbidden();
});
