<x-layouts.auth :title="'Peminjaman Libris'">
    <div class="w-full space-y-8">
        <div class="flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Peminjaman</p>
                <h1 class="text-4xl text-stone-50">Sirkulasi Peminjaman Buku</h1>
                <p class="max-w-2xl text-stone-300">
                    Catat peminjaman aktif, proses pengembalian, dan pantau status serta denda keterlambatan.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Dashboard
                </a>
                <a href="{{ route('admin.peminjaman.create') }}" class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
                    Catat Peminjaman
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-300/20 bg-emerald-300/10 px-5 py-4 text-sm text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-6">
            <form method="GET" action="{{ route('admin.peminjaman.index') }}" class="flex flex-col gap-4 lg:flex-row lg:items-center">
                <select name="status" class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none focus:border-amber-300/60 lg:max-w-xs">
                    <option value="">Semua Status</option>
                    <option value="dipinjam" @selected($status === 'dipinjam')>Dipinjam</option>
                    <option value="terlambat" @selected($status === 'terlambat')>Terlambat</option>
                    <option value="dikembalikan" @selected($status === 'dikembalikan')>Dikembalikan</option>
                </select>
                <button class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Filter
                </button>
            </form>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-stone-400">
                            <th class="px-6 py-4">Anggota</th>
                            <th class="px-6 py-4">Buku</th>
                            <th class="px-6 py-4">Tanggal Pinjam</th>
                            <th class="px-6 py-4">Jatuh Tempo</th>
                            <th class="px-6 py-4">Tanggal Kembali</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4">Denda</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 text-sm text-stone-200">
                        @forelse ($daftarPeminjaman as $peminjaman)
                            <tr class="align-top">
                                <td class="px-6 py-4">
                                    <div class="font-medium text-stone-50">{{ $peminjaman->anggota->name }}</div>
                                    <div class="text-stone-400">{{ $peminjaman->anggota->nim }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-medium text-stone-50">{{ $peminjaman->buku->judul }}</div>
                                    <div class="text-stone-400">{{ $peminjaman->buku->isbn }}</div>
                                </td>
                                <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam?->format('d M Y') }}</td>
                                <td class="px-6 py-4">{{ $peminjaman->tanggal_jatuh_tempo?->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    {{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}
                                </td>
                                <td class="px-6 py-4">
                                    <span class="rounded-full px-3 py-1 text-xs uppercase tracking-[0.16em]
                                        @class([
                                            'bg-amber-300/20 text-amber-200' => $peminjaman->status_peminjaman->value === 'dipinjam',
                                            'bg-rose-300/20 text-rose-200' => $peminjaman->status_peminjaman->value === 'terlambat',
                                            'bg-emerald-300/20 text-emerald-200' => $peminjaman->status_peminjaman->value === 'dikembalikan',
                                        ])">
                                        {{ $peminjaman->status_peminjaman->label() }}
                                    </span>
                                </td>
                                <td class="px-6 py-4">Rp{{ number_format((float) $peminjaman->jumlah_denda, 0, ',', '.') }}</td>
                                <td class="px-6 py-4">
                                    @if (! $peminjaman->sudahDikembalikan())
                                        <form method="POST" action="{{ route('admin.peminjaman.kembalikan', $peminjaman) }}">
                                            @csrf
                                            @method('PATCH')
                                            <button class="text-amber-200 transition hover:text-amber-100">
                                                Proses Pengembalian
                                            </button>
                                        </form>
                                    @else
                                        <span class="text-stone-500">Selesai</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-stone-400">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-6 py-4">
                {{ $daftarPeminjaman->links() }}
            </div>
        </div>
    </div>
</x-layouts.auth>
