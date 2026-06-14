<?php

namespace Database\Factories;

use App\Enums\StatusPeminjaman;
use App\Models\Buku;
use App\Models\Peminjaman;
use App\Models\User;
use Carbon\CarbonImmutable;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Peminjaman>
 */
class PeminjamanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $tanggalPinjam = CarbonImmutable::now()->subDays(fake()->numberBetween(1, 5));

        return [
            'anggota_id' => User::factory()->anggota(),
            'buku_id' => Buku::factory(),
            'tanggal_pinjam' => $tanggalPinjam,
            'tanggal_jatuh_tempo' => $tanggalPinjam->addDays(7),
            'tanggal_kembali' => null,
            'jumlah_denda' => 0,
            'status_peminjaman' => StatusPeminjaman::Dipinjam,
        ];
    }

    public function terlambat(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPinjam = CarbonImmutable::now()->subDays(10);

            return [
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalPinjam->addDays(7),
                'status_peminjaman' => StatusPeminjaman::Terlambat,
                'jumlah_denda' => 6000,
            ];
        });
    }

    public function dikembalikan(): static
    {
        return $this->state(function (array $attributes) {
            $tanggalPinjam = CarbonImmutable::now()->subDays(8);
            $tanggalKembali = $tanggalPinjam->addDays(9);

            return [
                'tanggal_pinjam' => $tanggalPinjam,
                'tanggal_jatuh_tempo' => $tanggalPinjam->addDays(7),
                'tanggal_kembali' => $tanggalKembali,
                'status_peminjaman' => StatusPeminjaman::Dikembalikan,
                'jumlah_denda' => 4000,
            ];
        });
    }
}
