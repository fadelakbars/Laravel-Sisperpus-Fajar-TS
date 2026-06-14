<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <div class="sm:col-span-2">
        <label for="gambar_sampul" class="text-sm font-medium text-slate-700">
            Gambar Sampul
        </label>
        <div class="mt-1 flex flex-col gap-4 rounded-2xl border border-dashed border-slate-300 bg-slate-50 p-4 sm:flex-row sm:items-center">
            <div class="flex h-28 w-20 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm">
                @if(isset($buku) && $buku->urlGambarSampul())
                    <img src="{{ $buku->urlGambarSampul() }}" alt="Sampul {{ $buku->judul }}" class="h-full w-full object-cover">
                @else
                    <div class="px-3 text-center text-[11px] font-semibold uppercase tracking-[0.2em] text-slate-400">
                        Belum Ada
                    </div>
                @endif
            </div>
            <div class="flex-1">
                <input
                    type="file"
                    id="gambar_sampul"
                    name="gambar_sampul"
                    accept="image/*"
                    class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 file:mr-4 file:rounded-md file:border-0 file:bg-indigo-50 file:px-3 file:py-2 file:text-sm file:font-semibold file:text-indigo-600 hover:file:bg-indigo-100"
                >
                <p class="mt-2 text-xs text-slate-500">Format: JPG, PNG, GIF, WEBP, BMP. Maksimal 2 MB.</p>
                @error('gambar_sampul')
                    <p class="mt-2 text-sm font-medium text-rose-600">{{ $message }}</p>
                @enderror
            </div>
        </div>
    </div>

    <div class="sm:col-span-2">
        <x-ui.input 
            label="Judul Buku" 
            name="judul" 
            :value="$buku->judul ?? null" 
            placeholder="Masukkan judul lengkap buku" 
            required 
        />
    </div>

    <x-ui.input 
        label="Penulis" 
        name="penulis" 
        :value="$buku->penulis ?? null" 
        placeholder="Nama penulis" 
        required 
    />

    <x-ui.input 
        label="ISBN" 
        name="isbn" 
        :value="$buku->isbn ?? null" 
        placeholder="Contoh: 978-602-..." 
        required 
    />

    <x-ui.input 
        label="Penerbit" 
        name="penerbit" 
        :value="$buku->penerbit ?? null" 
        placeholder="Nama penerbit" 
        required 
    />

    <x-ui.input 
        label="Tahun Terbit" 
        name="tahun_terbit" 
        type="number" 
        :value="$buku->tahun_terbit ?? null" 
        placeholder="Contoh: 2024" 
        required 
    />

    <x-ui.input 
        label="Jumlah Stok" 
        name="stok" 
        type="number" 
        :value="$buku->stok ?? 0" 
        required 
    />

    <x-ui.input 
        label="Lokasi Rak" 
        name="lokasi_rak" 
        :value="$buku->lokasi_rak ?? null" 
        placeholder="Contoh: R-01-A" 
        required 
    />
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <x-ui.button type="link" href="{{ route('admin.buku.index') }}" variant="secondary">
        Batal
    </x-ui.button>
    <x-ui.button type="submit">
        {{ isset($buku) ? 'Simpan Perubahan' : 'Tambah Buku' }}
    </x-ui.button>
</div>
