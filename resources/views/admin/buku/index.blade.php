<x-layouts.auth :title="'Manajemen Buku Libris'">
    <div class="w-full space-y-8">
        <div class="flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Buku</p>
                <h1 class="text-4xl text-stone-50">Manajemen Katalog Buku</h1>
                <p class="max-w-2xl text-stone-300">
                    Kelola katalog buku perpustakaan, perbarui stok, dan rapikan data bibliografi sebelum modul sirkulasi aktif penuh.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Dashboard
                </a>
                <a href="{{ route('admin.buku.create') }}" class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
                    Tambah Buku
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-300/20 bg-emerald-300/10 px-5 py-4 text-sm text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-6">
            <form method="GET" action="{{ route('admin.buku.index') }}" class="flex flex-col gap-4 lg:flex-row">
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
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-white/10 bg-stone-900/70">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-white/10">
                    <thead class="bg-white/5">
                        <tr class="text-left text-xs uppercase tracking-[0.18em] text-stone-400">
                            <th class="px-6 py-4">ISBN</th>
                            <th class="px-6 py-4">Judul</th>
                            <th class="px-6 py-4">Penulis</th>
                            <th class="px-6 py-4">Penerbit</th>
                            <th class="px-6 py-4">Tahun</th>
                            <th class="px-6 py-4">Stok</th>
                            <th class="px-6 py-4">Lokasi</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 text-sm text-stone-200">
                        @forelse ($daftarBuku as $buku)
                            <tr class="align-top">
                                <td class="px-6 py-4">{{ $buku->isbn }}</td>
                                <td class="px-6 py-4 font-medium text-stone-50">{{ $buku->judul }}</td>
                                <td class="px-6 py-4">{{ $buku->penulis }}</td>
                                <td class="px-6 py-4">{{ $buku->penerbit }}</td>
                                <td class="px-6 py-4">{{ $buku->tahun_terbit }}</td>
                                <td class="px-6 py-4">{{ $buku->stok }}</td>
                                <td class="px-6 py-4">{{ $buku->lokasi_rak }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('admin.buku.edit', $buku) }}" class="text-amber-200 transition hover:text-amber-100">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.buku.destroy', $buku) }}" onsubmit="return confirm('Hapus buku ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-rose-300 transition hover:text-rose-200">
                                                Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="px-6 py-8 text-center text-stone-400">
                                    Belum ada data buku.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-6 py-4">
                {{ $daftarBuku->links() }}
            </div>
        </div>
    </div>
</x-layouts.auth>
