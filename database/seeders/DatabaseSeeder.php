<?php

namespace Database\Seeders;

use App\Models\Buku;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::query()->updateOrCreate([
            'email' => 'admin@libris.test',
        ], [
            'name' => 'Admin Perpustakaan',
            'nim' => null,
            'peran' => 'admin',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);

        User::query()->updateOrCreate([
            'email' => 'anggota@libris.test',
        ], [
            'name' => 'Anggota Demo',
            'nim' => '2300000001',
            'peran' => 'anggota',
            'email_verified_at' => now(),
            'password' => 'password',
        ]);

        $bukuAwal = collect([
            [
                'isbn' => '9786020324784',
                'judul' => 'Pemrograman Laravel Dasar',
                'penulis' => 'Fajar Nugraha',
                'penerbit' => 'Informatika Nusantara',
                'tahun_terbit' => 2022,
                'stok' => 5,
                'lokasi_rak' => 'Rak A-1',
            ],
            [
                'isbn' => '9786230012457',
                'judul' => 'Basis Data untuk Kampus',
                'penulis' => 'Dian Prasetyo',
                'penerbit' => 'Cakrawala Ilmu',
                'tahun_terbit' => 2021,
                'stok' => 4,
                'lokasi_rak' => 'Rak A-2',
            ],
            [
                'isbn' => '9786238899012',
                'judul' => 'Algoritma dan Struktur Data',
                'penulis' => 'Rina Kurniawati',
                'penerbit' => 'Tekno Press',
                'tahun_terbit' => 2020,
                'stok' => 6,
                'lokasi_rak' => 'Rak B-1',
            ],
            [
                'isbn' => '9786020673318',
                'judul' => 'Rekayasa Perangkat Lunak Modern',
                'penulis' => 'Andi Saputra',
                'penerbit' => 'Media Akademik',
                'tahun_terbit' => 2023,
                'stok' => 3,
                'lokasi_rak' => 'Rak B-2',
            ],
            [
                'isbn' => '9786028519230',
                'judul' => 'Jaringan Komputer Praktis',
                'penulis' => 'Rahmat Hidayat',
                'penerbit' => 'Pustaka Digital',
                'tahun_terbit' => 2019,
                'stok' => 2,
                'lokasi_rak' => 'Rak C-1',
            ],
            [
                'isbn' => '9786237131458',
                'judul' => 'Analisis Sistem Informasi',
                'penulis' => 'Siti Marlina',
                'penerbit' => 'Insan Teknologi',
                'tahun_terbit' => 2021,
                'stok' => 4,
                'lokasi_rak' => 'Rak C-2',
            ],
        ]);

        $bukuAwal->each(function (array $buku): void {
            Buku::query()->updateOrCreate(
                ['isbn' => $buku['isbn']],
                $buku,
            );
        });

        if (Buku::query()->count() < 6) {
            Buku::factory(6 - Buku::query()->count())->create();
        }
    }
}
