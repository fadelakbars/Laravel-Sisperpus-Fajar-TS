<?php

namespace App\Enums;

enum PeranPengguna: string
{
    case Admin = 'admin';
    case Anggota = 'anggota';

    public function label(): string
    {
        return match ($this) {
            self::Admin => 'Admin',
            self::Anggota => 'Anggota',
        };
    }
}
