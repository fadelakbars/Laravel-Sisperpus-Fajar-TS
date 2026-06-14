<?php

namespace App\Models;

use App\Enums\PeranPengguna;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'nim', 'peran'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'peran' => PeranPengguna::class,
        ];
    }

    /**
     * @return HasMany<Peminjaman, $this>
     */
    public function peminjaman(): HasMany
    {
        return $this->hasMany(Peminjaman::class, 'anggota_id');
    }

    public function punyaPeminjamanAktif(): bool
    {
        return $this->peminjaman()
            ->whereIn('status_peminjaman', [
                \App\Enums\StatusPeminjaman::Dipinjam,
                \App\Enums\StatusPeminjaman::Terlambat
            ])
            ->exists();
    }

    public function punyaDenda(): bool
    {
        return (float) $this->peminjaman()->sum('jumlah_denda') > 0;
    }

    public function bisaDownloadSuratBebas(): bool
    {
        return !$this->punyaPeminjamanAktif() && !$this->punyaDenda();
    }

    public function adalahAdmin(): bool
    {
        return $this->peran === PeranPengguna::Admin;
    }

    public function adalahAnggota(): bool
    {
        return $this->peran === PeranPengguna::Anggota;
    }
}
