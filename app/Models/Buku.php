<?php

namespace App\Models;

use Database\Factories\BukuFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

#[Fillable([
    'isbn',
    'judul',
    'penulis',
    'penerbit',
    'tahun_terbit',
    'stok',
    'lokasi_rak',
    'gambar_sampul',
])]
class Buku extends Model
{
    /** @use HasFactory<BukuFactory> */
    use HasFactory;

    protected $table = 'buku';

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'stok' => 0,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tahun_terbit' => 'integer',
            'stok' => 'integer',
        ];
    }

    /**
     * @return HasMany<Peminjaman, $this>
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }

    public function urlGambarSampul(): ?string
    {
        if ($this->gambar_sampul === null) {
            return null;
        }

        return Storage::disk('public')->url($this->gambar_sampul);
    }
}
