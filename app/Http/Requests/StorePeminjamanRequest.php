<?php

namespace App\Http\Requests;

use App\Enums\PeranPengguna;
use App\Models\Buku;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Validator;

class StorePeminjamanRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()?->adalahAdmin() ?? false;
    }

    /**
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'anggota_id' => [
                'required',
                Rule::exists('users', 'id')->where('peran', PeranPengguna::Anggota->value),
            ],
            'buku_ids' => ['required', 'array', 'min:1'],
            'buku_ids.*' => ['required', Rule::exists('buku', 'id')],
            'tanggal_pinjam' => ['required', 'date'],
            'tanggal_jatuh_tempo' => ['required', 'date', 'after_or_equal:tanggal_pinjam'],
        ];
    }

    protected function prepareForValidation(): void
    {
        if (! $this->filled('tanggal_pinjam')) {
            $this->merge(['tanggal_pinjam' => now()->toDateString()]);
        }

        if (! $this->filled('tanggal_jatuh_tempo')) {
            $this->merge([
                'tanggal_jatuh_tempo' => now()->addDays(7)->toDateString(),
            ]);
        }
    }

    /**
     * @return array<int, callable(Validator): void>
     */
    public function after(): array
    {
        return [
            function (Validator $validator): void {
                $bukuIds = (array) $this->input('buku_ids');

                foreach ($bukuIds as $bukuId) {
                    $buku = Buku::query()->find($bukuId);

                    if ($buku instanceof Buku && $buku->stok < 1) {
                        $validator->errors()->add('buku_ids', "Buku '{$buku->judul}' sedang tidak tersedia.");
                    }
                }
            },
        ];
    }
}
