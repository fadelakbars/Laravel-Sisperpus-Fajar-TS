<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
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
