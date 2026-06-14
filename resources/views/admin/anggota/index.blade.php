<x-layouts.auth :title="'Manajemen Anggota Libris'">
    <div class="w-full space-y-8">
        <div class="flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl lg:flex-row lg:items-end lg:justify-between">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Anggota</p>
                <h1 class="text-4xl text-stone-50">Manajemen Anggota</h1>
                <p class="max-w-2xl text-stone-300">
                    Kelola akun anggota perpustakaan untuk kebutuhan katalog, peminjaman, dan riwayat sirkulasi.
                </p>
            </div>
            <div class="flex flex-wrap gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Dashboard
                </a>
                <a href="{{ route('admin.anggota.create') }}" class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
                    Tambah Anggota
                </a>
            </div>
        </div>

        @if (session('status'))
            <div class="rounded-2xl border border-emerald-300/20 bg-emerald-300/10 px-5 py-4 text-sm text-emerald-100">
                {{ session('status') }}
            </div>
        @endif

        <div class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-6">
            <form method="GET" action="{{ route('admin.anggota.index') }}" class="flex flex-col gap-4 lg:flex-row">
                <input
                    type="text"
                    name="cari"
                    value="{{ $kataKunci }}"
                    placeholder="Cari nama, email, atau NIM"
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
                            <th class="px-6 py-4">Nama</th>
                            <th class="px-6 py-4">Email</th>
                            <th class="px-6 py-4">NIM</th>
                            <th class="px-6 py-4">Terdaftar</th>
                            <th class="px-6 py-4">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-white/10 text-sm text-stone-200">
                        @forelse ($daftarAnggota as $anggota)
                            <tr class="align-top">
                                <td class="px-6 py-4 font-medium text-stone-50">{{ $anggota->name }}</td>
                                <td class="px-6 py-4">{{ $anggota->email }}</td>
                                <td class="px-6 py-4">{{ $anggota->nim }}</td>
                                <td class="px-6 py-4">{{ $anggota->created_at?->format('d M Y') }}</td>
                                <td class="px-6 py-4">
                                    <div class="flex flex-wrap gap-3">
                                        <a href="{{ route('admin.anggota.edit', $anggota) }}" class="text-amber-200 transition hover:text-amber-100">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.anggota.destroy', $anggota) }}" onsubmit="return confirm('Hapus anggota ini?');">
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
                                <td colspan="5" class="px-6 py-8 text-center text-stone-400">
                                    Belum ada data anggota.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="border-t border-white/10 px-6 py-4">
                {{ $daftarAnggota->links() }}
            </div>
        </div>
    </div>
</x-layouts.auth>
