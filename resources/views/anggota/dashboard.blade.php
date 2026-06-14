<x-layouts.auth :title="'Dashboard Anggota Libris'">
    <div class="w-full space-y-8">
        <div class="flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl md:flex-row md:items-center md:justify-between">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Dashboard Anggota</p>
                <h1 class="text-4xl text-stone-50">Halo, {{ auth()->user()->name }}</h1>
                <p class="max-w-2xl text-stone-300">
                    Telusuri katalog buku perpustakaan, cek ketersediaan, dan pantau riwayat peminjaman pribadi Anda dalam satu halaman.
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Logout
                </button>
            </form>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">Peran</p>
                <p class="mt-3 text-3xl text-stone-50">Anggota</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">NIM</p>
                <p class="mt-3 text-xl text-stone-50">{{ auth()->user()->nim }}</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">Riwayat Anda</p>
                <p class="mt-3 text-xl text-stone-50">{{ $riwayatPeminjaman->total() }} transaksi</p>
            </div>
        </div>

        <section class="space-y-5 rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Katalog Buku</p>
                <h2 class="text-3xl text-stone-50">Cari Buku Tersedia</h2>
            </div>

            <form method="GET" action="{{ route('anggota.dashboard') }}" class="flex flex-col gap-4 lg:flex-row">
                <input
                    type="text"
                    name="cari"
                    value="{{ $kataKunci }}"
                    placeholder="Cari judul, penulis, penerbit, atau ISBN"
                    class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60"
                >
                <button class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Cari
                </button>
            </form>

            <div class="grid gap-4 md:grid-cols-2 xl:grid-cols-4">
                @forelse ($daftarBuku as $buku)
                    <article class="rounded-3xl border border-white/10 bg-black/20 p-5">
                        <p class="text-xs uppercase tracking-[0.2em] text-stone-500">{{ $buku->isbn }}</p>
                        <h3 class="mt-3 text-xl text-stone-50">{{ $buku->judul }}</h3>
                        <p class="mt-2 text-sm text-stone-300">{{ $buku->penulis }}</p>
                        <p class="text-sm text-stone-400">{{ $buku->penerbit }} · {{ $buku->tahun_terbit }}</p>
                        <div class="mt-5 flex items-center justify-between">
                            <span class="rounded-full px-3 py-1 text-xs uppercase tracking-[0.16em]
                                @class([
                                    'bg-emerald-300/20 text-emerald-200' => $buku->stok > 0,
                                    'bg-rose-300/20 text-rose-200' => $buku->stok === 0,
                                ])">
                                {{ $buku->stok > 0 ? 'Tersedia' : 'Habis' }}
                            </span>
                            <span class="text-sm text-stone-300">Stok: {{ $buku->stok }}</span>
                        </div>
                        <p class="mt-4 text-sm text-stone-400">Lokasi: {{ $buku->lokasi_rak }}</p>
                    </article>
                @empty
                    <div class="rounded-3xl border border-white/10 bg-black/20 p-5 text-stone-400 md:col-span-2 xl:col-span-4">
                        Tidak ada buku yang cocok dengan pencarian Anda.
                    </div>
                @endforelse
            </div>

            <div>
                {{ $daftarBuku->links() }}
            </div>
        </section>

        <section class="space-y-5 rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Riwayat Peminjaman</p>
                <h2 class="text-3xl text-stone-50">Transaksi Pribadi</h2>
            </div>

            <div class="overflow-hidden rounded-[1.5rem] border border-white/10">
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-white/10">
                        <thead class="bg-white/5">
                            <tr class="text-left text-xs uppercase tracking-[0.18em] text-stone-400">
                                <th class="px-6 py-4">Buku</th>
                                <th class="px-6 py-4">Pinjam</th>
                                <th class="px-6 py-4">Jatuh Tempo</th>
                                <th class="px-6 py-4">Kembali</th>
                                <th class="px-6 py-4">Status</th>
                                <th class="px-6 py-4">Denda</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-white/10 text-sm text-stone-200">
                            @forelse ($riwayatPeminjaman as $peminjaman)
                                <tr class="align-top">
                                    <td class="px-6 py-4">
                                        <div class="font-medium text-stone-50">{{ $peminjaman->buku->judul }}</div>
                                        <div class="text-stone-400">{{ $peminjaman->buku->isbn }}</div>
                                    </td>
                                    <td class="px-6 py-4">{{ $peminjaman->tanggal_pinjam?->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $peminjaman->tanggal_jatuh_tempo?->format('d M Y') }}</td>
                                    <td class="px-6 py-4">{{ $peminjaman->tanggal_kembali?->format('d M Y') ?? '-' }}</td>
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
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-8 text-center text-stone-400">
                                        Anda belum memiliki riwayat peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div>
                {{ $riwayatPeminjaman->links() }}
            </div>
        </section>
    </div>
</x-layouts.auth>
