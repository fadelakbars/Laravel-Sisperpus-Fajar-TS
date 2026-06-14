<x-layouts.app :title="'Manajemen Buku - Sisperpus'">
    <div x-data="{ 
        detailBuku: null,
        bukaDetail(buku) {
            this.detailBuku = buku;
            this.$dispatch('open-modal', { name: 'detail-buku' });
        }
    }" class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Katalog Buku</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola koleksi buku dan ketersediaan stok perpustakaan.</p>
            </div>
            <div>
                <x-ui.button type="link" href="{{ route('admin.buku.create') }}">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Buku
                </x-ui.button>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <x-ui.card padding="p-0">
            <div class="border-b border-slate-100 p-4">
                <form method="GET" action="{{ route('admin.buku.index') }}" class="flex max-w-sm gap-2">
                    <x-ui.input 
                        name="cari" 
                        :value="$kataKunci" 
                        placeholder="Cari judul, penulis, atau ISBN..." 
                        class="py-1.5"
                    />
                    <x-ui.button type="submit" variant="secondary" class="py-1.5">Cari</x-ui.button>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Sampul</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Informasi Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Katalog</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Stok & Rak</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($daftarBuku as $buku)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="flex h-20 w-14 items-center justify-center overflow-hidden rounded-xl border border-slate-200 bg-slate-50 shadow-sm">
                                        @if($buku->urlGambarSampul())
                                            <img src="{{ $buku->urlGambarSampul() }}" alt="Sampul {{ $buku->judul }}" class="h-full w-full object-cover">
                                        @else
                                            <span class="px-2 text-center text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">No Cover</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $buku->judul }}</div>
                                    <div class="text-xs text-slate-500">{{ $buku->penulis }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs font-mono text-slate-600 bg-slate-100 px-2 py-0.5 rounded inline-block">{{ $buku->isbn }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $buku->penerbit }} ({{ $buku->tahun_terbit }})</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center gap-2">
                                        <x-ui.badge :variant="$buku->stok > 0 ? 'success' : 'danger'">
                                            {{ $buku->stok }} Stok
                                        </x-ui.badge>
                                        <span class="text-xs text-slate-400">Rak: {{ $buku->lokasi_rak }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end items-center gap-4">
                                        <button 
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
                                            class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition flex items-center"
                                        >
                                            Detail
                                        </button>
                                        <a href="{{ route('admin.buku.edit', $buku) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 transition flex items-center">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}" onsubmit="return confirm('Hapus buku ini?');" class="flex items-center">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600 hover:text-rose-900 transition flex items-center">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $daftarBuku->links() }}
            </div>
        </x-ui.card>

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
                    </div>
                </div>
            </template>
        </x-ui.modal>
    </div>
</x-layouts.app>
