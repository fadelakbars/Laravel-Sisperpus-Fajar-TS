@csrf

<div class="grid gap-6 md:grid-cols-2">
    <div class="space-y-2">
        <label for="isbn" class="text-sm text-stone-300">ISBN</label>
        <input id="isbn" name="isbn" type="text" value="{{ old('isbn', $buku->isbn ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('isbn')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="judul" class="text-sm text-stone-300">Judul</label>
        <input id="judul" name="judul" type="text" value="{{ old('judul', $buku->judul ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('judul')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="penulis" class="text-sm text-stone-300">Penulis</label>
        <input id="penulis" name="penulis" type="text" value="{{ old('penulis', $buku->penulis ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('penulis')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="penerbit" class="text-sm text-stone-300">Penerbit</label>
        <input id="penerbit" name="penerbit" type="text" value="{{ old('penerbit', $buku->penerbit ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('penerbit')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="tahun_terbit" class="text-sm text-stone-300">Tahun Terbit</label>
        <input id="tahun_terbit" name="tahun_terbit" type="number" value="{{ old('tahun_terbit', $buku->tahun_terbit ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('tahun_terbit')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="stok" class="text-sm text-stone-300">Stok</label>
        <input id="stok" name="stok" type="number" value="{{ old('stok', $buku->stok ?? 0) }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('stok')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="lokasi_rak" class="text-sm text-stone-300">Lokasi Rak</label>
        <input id="lokasi_rak" name="lokasi_rak" type="text" value="{{ old('lokasi_rak', $buku->lokasi_rak ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('lokasi_rak')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
        {{ $tombol }}
    </button>
    <a href="{{ route('admin.buku.index') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
        Batal
    </a>
</div>
