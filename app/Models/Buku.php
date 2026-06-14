<?php

namespace App\Models;

use Database\Factories\BukuFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

#[Fillable([
    'isbn',
    'judul',
    'penulis',
    'penerbit',
    'tahun_terbit',
    'stok',
    'lokasi_rak',
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
}
