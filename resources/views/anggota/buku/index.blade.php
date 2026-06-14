<x-layouts.app :title="'Katalog Buku - Sisperpus'">
    <div class="space-y-8">
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
                    <x-ui.card padding="p-0" class="group transition-all hover:border-indigo-200 hover:shadow-md overflow-hidden">
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

        <x-ui.card padding="p-4" class="bg-indigo-50 border-indigo-100">
            <div class="flex gap-x-3">
                <svg class="h-6 w-6 text-indigo-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M11.25 11.25l.041-.02a.75.75 0 011.063.852l-.708 2.836a.75.75 0 001.063.853l.041-.021M21 12a9 9 0 11-18 0 9 9 0 0118 0zm-9-3.75h.008v.008H12V8.25z" />
                </svg>
                <p class="text-sm text-indigo-800 leading-6">
                    <strong>Cara meminjam:</strong> Catat Judul Buku dan Lokasi Rak, lalu bawa buku fisik ke meja Pustakawan untuk proses peminjaman.
                </p>
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
