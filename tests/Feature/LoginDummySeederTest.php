<?php

use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('akun admin dummy dari seeder dapat login', function () {
    $this->seed(DatabaseSeeder::class);

    $response = $this->post('/login', [
        'email' => 'admin@sisperpus.test',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('admin.dashboard'));
    $this->assertAuthenticated();
});

test('akun anggota dummy dari seeder dapat login', function () {
    $this->seed(DatabaseSeeder::class);

    $response = $this->post('/login', [
        'email' => 'anggota@sisperpus.test',
        'password' => 'password',
    ]);

    $response->assertRedirect(route('anggota.dashboard'));
    $this->assertAuthenticated();
});

test('seeder menyelaraskan akun demo lama ke email dummy yang terdokumentasi', function () {
    User::factory()->admin()->create([
        'email' => 'admin@libris.test',
    ]);

    User::factory()->anggota()->create([
        'email' => 'anggota@libris.test',
    ]);

    $this->seed(DatabaseSeeder::class);

    $this->assertDatabaseHas('users', ['email' => 'admin@sisperpus.test']);
    $this->assertDatabaseHas('users', ['email' => 'anggota@sisperpus.test']);
    $this->assertDatabaseMissing('users', ['email' => 'admin@libris.test']);
    $this->assertDatabaseMissing('users', ['email' => 'anggota@libris.test']);
});
