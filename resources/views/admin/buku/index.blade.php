<x-layouts.app :title="'Manajemen Buku - Libris'">
    <div class="space-y-6">
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
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.buku.edit', $buku) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 transition">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}" onsubmit="return confirm('Hapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-sm font-semibold text-rose-600 hover:text-rose-900 transition">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada data buku.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $daftarBuku->links() }}
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
