<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;

class StoreBukuRequest extends FormRequest
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
            'isbn' => ['required', 'string', 'max:255', 'unique:buku,isbn'],
            'judul' => ['required', 'string', 'max:255'],
            'penulis' => ['required', 'string', 'max:255'],
            'penerbit' => ['required', 'string', 'max:255'],
            'tahun_terbit' => ['required', 'integer', 'digits:4', 'min:1900', 'max:'.(int) now()->format('Y')],
            'stok' => ['required', 'integer', 'min:0'],
            'lokasi_rak' => ['required', 'string', 'max:255'],
            'gambar_sampul' => ['nullable', File::image()->max('2mb')],
        ];
    }
}
