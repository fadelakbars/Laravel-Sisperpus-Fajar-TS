<x-layouts.app :title="'Dashboard Anggota - Sisperpus'">
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Halo, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-sm text-slate-500">Pantau aktivitas peminjaman dan denda Anda di sini.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-3">
            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-indigo-50 p-2 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">NIM</p>
                        <p class="text-lg font-bold text-slate-900">{{ auth()->user()->nim }}</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Buku Dipinjam</p>
                        <p class="text-2xl font-bold text-slate-900">{{ $riwayatPeminjaman->where('status_peminjaman.value', 'dipinjam')->count() }}</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-rose-50 p-2 text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Denda</p>
                        <p class="text-2xl font-bold text-slate-900">Rp{{ number_format((float) $riwayatPeminjaman->sum('jumlah_denda'), 0, ',', '.') }}</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <x-ui.card title="Riwayat Peminjaman Pribadi" description="Daftar buku yang pernah dan sedang Anda pinjam." padding="p-0">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Buku</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Pinjam / Tempo</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Denda</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($riwayatPeminjaman as $peminjaman)
                            <tr>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm font-semibold text-slate-900">{{ $peminjaman->buku->judul }}</div>
                                    <div class="text-xs text-slate-500">{{ $peminjaman->buku->isbn }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <div class="text-sm text-slate-900">{{ $peminjaman->tanggal_pinjam?->format('d M Y') }}</div>
                                    <div class="text-xs text-rose-500 font-medium italic">{{ $peminjaman->tanggal_jatuh_tempo?->format('d M Y') }}</div>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4">
                                    <x-ui.badge :variant="match($peminjaman->status_peminjaman->value) {
                                        'dipinjam' => 'warning',
                                        'terlambat' => 'danger',
                                        'dikembalikan' => 'success',
                                        default => 'neutral'
                                    }">
                                        {{ $peminjaman->status_peminjaman->label() }}
                                    </x-ui.badge>
                                </td>
                                <td class="whitespace-nowrap px-6 py-4 text-sm font-medium text-slate-900">
                                    Rp{{ number_format((float) $peminjaman->jumlah_denda, 0, ',', '.') }}
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada riwayat peminjaman.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $riwayatPeminjaman->links() }}
            </div>
        </x-ui.card>

        <div class="flex justify-center">
            <x-ui.button type="link" href="{{ route('anggota.buku.index') }}" variant="primary" class="gap-2">
                <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                </svg>
                Buka Katalog & Cari Buku
            </x-ui.button>
        </div>
    </div>
</x-layouts.app>
