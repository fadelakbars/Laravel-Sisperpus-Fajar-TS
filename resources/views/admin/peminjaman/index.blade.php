<x-layouts.app :title="'Sirkulasi Peminjaman - Libris'">
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Sirkulasi Perpustakaan</h1>
                <p class="mt-1 text-sm text-slate-500">Pantau transaksi peminjaman, pengembalian, dan keterlambatan.</p>
            </div>
            <div>
                <x-ui.button type="link" href="{{ route('admin.peminjaman.create') }}">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Catat Peminjaman
                </x-ui.button>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-lg border border-emerald-200 bg-emerald-50 p-4 text-sm text-emerald-700">
                {{ session('status') }}
            </div>
        @endif

        <x-ui.card padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Buku & Anggota</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Tanggal</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Denda</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($daftarPeminjaman as $peminjaman)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $peminjaman->buku->judul }}</div>
                                    <div class="text-xs text-indigo-600 font-medium">Oleh: {{ $peminjaman->anggota->name }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-xs text-slate-500">Pinjam: <span class="text-slate-900 font-medium">{{ $peminjaman->tanggal_pinjam?->format('d/m/Y') }}</span></div>
                                    <div class="text-xs text-slate-500 mt-1">Tempo: <span class="text-rose-500 font-medium">{{ $peminjaman->tanggal_jatuh_tempo?->format('d/m/Y') }}</span></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-ui.badge :variant="match($peminjaman->status_peminjaman->value) {
                                        'dipinjam' => 'warning',
                                        'terlambat' => 'danger',
                                        'dikembalikan' => 'success',
                                        default => 'neutral'
                                    }">
                                        {{ $peminjaman->status_peminjaman->label() }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-slate-900">
                                    Rp{{ number_format((float) $peminjaman->jumlah_denda, 0, ',', '.') }}
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    @if ($peminjaman->status_peminjaman->value !== 'dikembalikan')
                                        <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}">
                                            @csrf
                                            @method('PATCH')
                                            <x-ui.button type="submit" variant="secondary" class="py-1 px-3 text-xs">
                                                Kembalikan
                                            </x-ui.button>
                                        </form>
                                    @else
                                        <span class="text-xs text-slate-400 italic">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada data transaksi.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $daftarPeminjaman->links() }}
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
