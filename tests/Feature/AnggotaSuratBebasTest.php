<?php

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('anggota yang tidak memiliki pinjaman aktif dan denda dapat mengunduh surat bebas', function () {
    $anggota = User::factory()->anggota()->create();
    
    // Skenario 1: Tidak punya riwayat sama sekali
    $response = $this->actingAs($anggota)->get(route('anggota.dashboard'));
    $response->assertSuccessful();
    $response->assertSee('Download Surat');
    $response->assertSee(route('anggota.surat-bebas'));

    $responseSurat = $this->actingAs($anggota)->get(route('anggota.surat-bebas'));
    $responseSurat->assertSuccessful();
    $responseSurat->assertSee('Surat Keterangan Bebas Perpustakaan');
    $responseSurat->assertSee($anggota->name);
    
    // Skenario 2: Punya riwayat tapi sudah dikembalikan dan tidak ada denda
    Peminjaman::factory()->create([
        'anggota_id' => $anggota->id,
        'status_peminjaman' => StatusPeminjaman::Dikembalikan,
        'jumlah_denda' => 0,
    ]);

    $response = $this->actingAs($anggota)->get(route('anggota.dashboard'));
    $response->assertSee('Download Surat');
    $this->actingAs($anggota)->get(route('anggota.surat-bebas'))->assertSuccessful();
});

test('anggota yang memiliki pinjaman aktif tidak dapat mengunduh surat bebas', function () {
    $anggota = User::factory()->anggota()->create();
    $buku = Buku::factory()->create();
    
    Peminjaman::factory()->create([
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'status_peminjaman' => StatusPeminjaman::Dipinjam,
    ]);

    $response = $this->actingAs($anggota)->get(route('anggota.dashboard'));
    $response->assertSuccessful();
    $response->assertSeeText('Selesaikan pinjaman & denda untuk mengunduh surat.');

    $this->actingAs($anggota)->get(route('anggota.surat-bebas'))
        ->assertForbidden();
});

test('anggota yang memiliki denda tidak dapat mengunduh surat bebas', function () {
    $anggota = User::factory()->anggota()->create();
    $buku = Buku::factory()->create();
    
    // Sudah dikembalikan tapi ada denda
    Peminjaman::factory()->create([
        'anggota_id' => $anggota->id,
        'buku_id' => $buku->id,
        'status_peminjaman' => StatusPeminjaman::Dikembalikan,
        'jumlah_denda' => 5000,
    ]);

    $response = $this->actingAs($anggota)->get(route('anggota.dashboard'));
    $response->assertSuccessful();
    $response->assertSeeText('Selesaikan pinjaman & denda untuk mengunduh surat.');

    $this->actingAs($anggota)->get(route('anggota.surat-bebas'))
        ->assertForbidden();
});
