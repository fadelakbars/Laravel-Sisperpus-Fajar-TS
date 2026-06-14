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
                    <x-ui.card padding="p-5" class="group transition-all hover:border-indigo-200 hover:shadow-md">
                        <p class="text-[10px] font-bold uppercase tracking-widest text-slate-400">{{ $buku->isbn }}</p>
                        <h3 class="mt-2 text-lg font-bold text-slate-900 line-clamp-2 group-hover:text-indigo-600">{{ $buku->judul }}</h3>
                        <p class="mt-1 text-sm text-slate-500">{{ $buku->penulis }}</p>
                        
                        <div class="mt-6 flex items-center justify-between">
                            <x-ui.badge :variant="$buku->stok > 0 ? 'success' : 'danger'">
                                {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </x-ui.badge>
                            <span class="text-xs text-slate-400">Stok: {{ $buku->stok }}</span>
                        </div>
                        <div class="mt-4 border-t border-slate-100 pt-4 flex items-center justify-between">
                            <span class="text-[11px] font-medium text-slate-400 uppercase">Lokasi</span>
                            <span class="text-xs font-semibold text-slate-600">{{ $buku->lokasi_rak }}</span>
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
