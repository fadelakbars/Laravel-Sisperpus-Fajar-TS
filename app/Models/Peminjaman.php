<?php

namespace App\Models;

use App\Enums\StatusPeminjaman;
use Carbon\CarbonInterface;
use Database\Factories\PeminjamanFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    /** @use HasFactory<PeminjamanFactory> */
    use HasFactory;

    protected $table = 'peminjaman';

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'anggota_id',
        'buku_id',
        'tanggal_pinjam',
        'tanggal_jatuh_tempo',
        'tanggal_kembali',
        'jumlah_denda',
        'status_peminjaman',
    ];

    /**
     * @var array<string, mixed>
     */
    protected $attributes = [
        'jumlah_denda' => 0,
        'status_peminjaman' => StatusPeminjaman::Dipinjam->value,
    ];

    /**
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'tanggal_pinjam' => 'date',
            'tanggal_jatuh_tempo' => 'date',
            'tanggal_kembali' => 'date',
            'jumlah_denda' => 'decimal:2',
            'status_peminjaman' => StatusPeminjaman::class,
        ];
    }

    /**
     * @return BelongsTo<User, $this>
     */
    public function anggota(): BelongsTo
    {
        return $this->belongsTo(User::class, 'anggota_id');
    }

    /**
     * @return BelongsTo<Buku, $this>
     */
    public function buku(): BelongsTo
    {
        return $this->belongsTo(Buku::class, 'buku_id');
    }

    /**
     * @param  Builder<Peminjaman>  $query
     * @return Builder<Peminjaman>
     */
    public function scopeBelumDikembalikan(Builder $query): Builder
    {
        return $query->whereNull('tanggal_kembali');
    }

    public function sudahDikembalikan(): bool
    {
        return $this->status_peminjaman === StatusPeminjaman::Dikembalikan;
    }

    public function hitungJumlahDenda(CarbonInterface $tanggalReferensi): float
    {
        if ($tanggalReferensi->lte($this->tanggal_jatuh_tempo)) {
            return 0.0;
        }

        return (float) $this->tanggal_jatuh_tempo->diffInDays($tanggalReferensi) * 2000;
    }
}
