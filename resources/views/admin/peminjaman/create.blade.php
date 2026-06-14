<x-layouts.auth :title="'Catat Peminjaman Libris'">
    <div class="w-full space-y-8">
        <div class="space-y-2 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Peminjaman</p>
            <h1 class="text-4xl text-stone-50">Catat Peminjaman Baru</h1>
            <p class="max-w-2xl text-stone-300">
                Pilih anggota dan buku yang tersedia, lalu tetapkan tanggal pinjam dan jatuh tempo pengembalian.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.peminjaman.store') }}" class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            @csrf

            <div class="grid gap-6 md:grid-cols-2">
                <div class="space-y-2">
                    <label for="anggota_id" class="text-sm text-stone-300">Anggota</label>
                    <select id="anggota_id" name="anggota_id" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none focus:border-amber-300/60">
                        <option value="">Pilih anggota</option>
                        @foreach ($daftarAnggota as $anggota)
                            <option value="{{ $anggota->id }}" @selected((string) old('anggota_id') === (string) $anggota->id)>
                                {{ $anggota->name }} - {{ $anggota->nim }}
                            </option>
                        @endforeach
                    </select>
                    @error('anggota_id')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="buku_id" class="text-sm text-stone-300">Buku</label>
                    <select id="buku_id" name="buku_id" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none focus:border-amber-300/60">
                        <option value="">Pilih buku tersedia</option>
                        @foreach ($daftarBuku as $buku)
                            <option value="{{ $buku->id }}" @selected((string) old('buku_id') === (string) $buku->id)>
                                {{ $buku->judul }} - stok {{ $buku->stok }}
                            </option>
                        @endforeach
                    </select>
                    @error('buku_id')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="tanggal_pinjam" class="text-sm text-stone-300">Tanggal Pinjam</label>
                    <input id="tanggal_pinjam" name="tanggal_pinjam" type="date" value="{{ old('tanggal_pinjam', now()->toDateString()) }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none focus:border-amber-300/60">
                    @error('tanggal_pinjam')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="tanggal_jatuh_tempo" class="text-sm text-stone-300">Tanggal Jatuh Tempo</label>
                    <input id="tanggal_jatuh_tempo" name="tanggal_jatuh_tempo" type="date" value="{{ old('tanggal_jatuh_tempo', now()->addDays(7)->toDateString()) }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none focus:border-amber-300/60">
                    @error('tanggal_jatuh_tempo')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="mt-8 flex flex-wrap gap-3">
                <button class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
                    Simpan Peminjaman
                </button>
                <a href="{{ route('admin.peminjaman.index') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Batal
                </a>
            </div>
        </form>
    </div>
</x-layouts.auth>
