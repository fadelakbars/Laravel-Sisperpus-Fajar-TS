<x-layouts.app :title="'Katalog Buku - Sisperpus'">
    <div x-data="{ 
        detailBuku: null,
        bukaDetail(buku) {
            this.detailBuku = buku;
            this.$dispatch('open-modal', { name: 'detail-buku' });
        }
    }" class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Katalog Buku</h1>
            <p class="mt-2 text-sm text-slate-500">Telusuri koleksi lengkap buku perpustakaan kami.</p>
        </div>

        <section class="space-y-6">
            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                <form method="GET" action="{{ route('anggota.buku.index') }}" class="flex w-full max-w-sm gap-2">
                    <x-ui.input 
                        name="cari" 
                        :value="$kataKunci" 
                        placeholder="Cari judul, penulis, atau ISBN..." 
                        class="py-2"
                    />
                    <x-ui.button type="submit">Cari</x-ui.button>
                </form>
            </div>

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($daftarBuku as $buku)
                    <x-ui.card 
                        padding="p-0" 
                        class="group transition-all hover:border-indigo-200 hover:shadow-md overflow-hidden cursor-pointer"
                        @click="bukaDetail({{ json_encode([
                            'judul' => $buku->judul,
                            'penulis' => $buku->penulis,
                            'penerbit' => $buku->penerbit,
                            'tahun_terbit' => $buku->tahun_terbit,
                            'isbn' => $buku->isbn,
                            'stok' => $buku->stok,
                            'lokasi_rak' => $buku->lokasi_rak,
                            'url_gambar' => $buku->urlGambarSampul(),
                            'stok_label' => $buku->stok > 0 ? 'Tersedia' : 'Habis',
                            'stok_variant' => $buku->stok > 0 ? 'success' : 'danger'
                        ]) }})"
                    >
                        <div class="aspect-[2/3] w-full overflow-hidden bg-slate-100 relative">
                            @if($buku->gambar_sampul)
                                <img src="{{ $buku->urlGambarSampul() }}" alt="{{ $buku->judul }}" class="h-full w-full object-cover transition duration-300 group-hover:scale-105">
                            @else
                                <div class="flex h-full w-full items-center justify-center text-slate-400">
                                    <svg class="h-12 w-12" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute top-3 right-3">
                                <x-ui.badge :variant="$buku->stok > 0 ? 'success' : 'danger'" class="shadow-sm backdrop-blur-md bg-white/90">
                                    {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                                </x-ui.badge>
                            </div>
                        </div>
                        <div class="p-5">
                            <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $buku->isbn }}</p>
                            <h3 class="mt-2 text-lg font-bold text-slate-900 line-clamp-2 group-hover:text-indigo-600 h-14">{{ $buku->judul }}</h3>
                            <p class="mt-1 text-sm text-slate-500 truncate">{{ $buku->penulis }}</p>
                            
                            <div class="mt-4 border-t border-slate-100 pt-4 flex items-center justify-between">
                                <div class="flex flex-col">
                                    <span class="text-[10px] font-medium text-slate-400 uppercase">Lokasi</span>
                                    <span class="text-xs font-semibold text-slate-600">{{ $buku->lokasi_rak }}</span>
                                </div>
                                <div class="flex flex-col items-end">
                                    <span class="text-[10px] font-medium text-slate-400 uppercase">Stok</span>
                                    <span class="text-xs font-semibold text-slate-600">{{ $buku->stok }}</span>
                                </div>
                            </div>
                        </div>
                    </x-ui.card>
                @empty
                    <div class="col-span-full py-20 text-center bg-white rounded-xl border border-slate-200 border-dashed">
                        <p class="text-slate-400">Tidak ada buku yang ditemukan.</p>
                    </div>
                @endforelse
            </div>

            <div class="mt-8">
                {{ $daftarBuku->links() }}
            </div>
        </section>

        <!-- Modal Detail Buku -->
        <x-ui.modal name="detail-buku" title="Detail Informasi Buku">
            <template x-if="detailBuku">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="md:col-span-1">
                        <div class="aspect-[2/3] w-full overflow-hidden rounded-xl bg-slate-100 border border-slate-200">
                            <template x-if="detailBuku.url_gambar">
                                <img :src="detailBuku.url_gambar" :alt="detailBuku.judul" class="h-full w-full object-cover">
                            </template>
                            <template x-if="!detailBuku.url_gambar">
                                <div class="flex h-full w-full items-center justify-center text-slate-300">
                                    <svg class="h-16 w-16" fill="none" viewBox="0 0 24 24" stroke-width="1" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                                    </svg>
                                </div>
                            </template>
                        </div>
                    </div>
                    <div class="md:col-span-2 space-y-6">
                        <div>
                            <span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider transition-colors duration-200"
                                :class="{
                                    'bg-emerald-50 text-emerald-700 border border-emerald-200': detailBuku.stok > 0,
                                    'bg-rose-50 text-rose-700 border border-rose-200': detailBuku.stok === 0
                                }"
                                x-text="detailBuku.stok_label">
                            </span>
                            <h2 class="mt-3 text-2xl font-bold text-slate-900" x-text="detailBuku.judul"></h2>
                            <p class="mt-1 text-lg text-slate-600" x-text="detailBuku.penulis"></p>
                        </div>

                        <div class="grid grid-cols-2 gap-y-4 gap-x-8 border-t border-slate-100 pt-6">
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">ISBN</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700 font-mono" x-text="detailBuku.isbn"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Penerbit</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700" x-text="detailBuku.penerbit"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Tahun Terbit</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700" x-text="detailBuku.tahun_terbit"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Lokasi Rak</p>
                                <p class="mt-1 text-sm font-semibold text-indigo-600" x-text="detailBuku.lokasi_rak"></p>
                            </div>
                            <div>
                                <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">Sisa Stok</p>
                                <p class="mt-1 text-sm font-semibold text-slate-700" x-text="detailBuku.stok + ' eksemplar'"></p>
                            </div>
                        </div>

                        <div class="rounded-xl bg-slate-50 p-4 border border-slate-100">
                            <p class="text-xs text-slate-500 leading-5">
                                <strong class="text-slate-700">Catatan Peminjaman:</strong> Silakan hubungi pustakawan di meja pelayanan dengan menyebutkan judul buku atau menunjukkan ISBN untuk memproses peminjaman fisik.
                            </p>
                        </div>
                    </div>
                </div>
            </template>
        </x-ui.modal>

        <x-ui.card padding="p-4" class="bg-indigo-50 border-indigo-100">
            <div class="flex gap-x-3">
                <svg class="h-6 w-6 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <p class="text-sm text-indigo-800 leading-6">
                    <strong>Cara meminjam:</strong> Klik buku untuk melihat detail, lalu bawa buku fisik ke meja Pustakawan untuk proses peminjaman.
                </p>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
