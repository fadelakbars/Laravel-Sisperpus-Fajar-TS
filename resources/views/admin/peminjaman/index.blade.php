<x-layouts.app :title="'Sirkulasi Peminjaman - Sisperpus'">
    <div x-data="{ 
        detailPeminjaman: null,
        bukaDetail(data) {
            this.detailPeminjaman = data;
            this.$dispatch('open-modal', { name: 'detail-peminjaman' });
        }
    }" class="space-y-6">
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
                                    <div class="flex justify-end items-center gap-3">
                                        <button 
                                            @click="bukaDetail({{ json_encode([
                                                'id' => $peminjaman->id,
                                                'buku' => [
                                                    'judul' => $peminjaman->buku->judul,
                                                    'isbn' => $peminjaman->buku->isbn,
                                                    'penerbit' => $peminjaman->buku->penerbit,
                                                    'penulis' => $peminjaman->buku->penulis,
                                                ],
                                                'anggota' => [
                                                    'name' => $peminjaman->anggota->name,
                                                    'nim' => $peminjaman->anggota->nim,
                                                    'email' => $peminjaman->anggota->email,
                                                ],
                                                'tanggal_pinjam' => $peminjaman->tanggal_pinjam?->format('d/m/Y'),
                                                'tanggal_jatuh_tempo' => $peminjaman->tanggal_jatuh_tempo?->format('d/m/Y'),
                                                'tanggal_kembali' => $peminjaman->tanggal_kembali?->format('d/m/Y'),
                                                'status_label' => $peminjaman->status_peminjaman->label(),
                                                'status_value' => $peminjaman->status_peminjaman->value,
                                                'jumlah_denda' => 'Rp' . number_format((float) $peminjaman->jumlah_denda, 0, ',', '.'),
                                            ]) }})"
                                            class="text-xs font-semibold text-slate-600 hover:text-indigo-600 transition"
                                        >
                                            Detail
                                        </button>

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
                                    </div>
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

        <!-- Modal Detail Peminjaman -->
        <x-ui.modal name="detail-peminjaman" title="Detail Transaksi Peminjaman">
            <template x-if="detailPeminjaman">
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Informasi Anggota -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400">Informasi Peminjam</h3>
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Nama Lengkap</p>
                                    <p class="text-sm font-semibold text-slate-900" x-text="detailPeminjaman.anggota.name"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">NIM / ID</p>
                                    <p class="text-sm font-semibold text-slate-700" x-text="detailPeminjaman.anggota.nim || '-'"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Email</p>
                                    <p class="text-sm font-medium text-slate-600" x-text="detailPeminjaman.anggota.email"></p>
                                </div>
                            </div>
                        </div>

                        <!-- Informasi Buku -->
                        <div class="space-y-4">
                            <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400">Buku yang Dipinjam</h3>
                            <div class="rounded-xl border border-slate-100 bg-slate-50 p-4 space-y-3">
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Judul Buku</p>
                                    <p class="text-sm font-semibold text-indigo-600" x-text="detailPeminjaman.buku.judul"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">Penulis / Penerbit</p>
                                    <p class="text-xs text-slate-600" x-text="detailPeminjaman.buku.penulis + ' | ' + detailPeminjaman.buku.penerbit"></p>
                                </div>
                                <div>
                                    <p class="text-[10px] font-bold uppercase text-slate-400">ISBN</p>
                                    <p class="text-xs font-mono text-slate-500" x-text="detailPeminjaman.buku.isbn"></p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Status Transaksi -->
                    <div class="space-y-4 pt-4 border-t border-slate-100">
                        <h3 class="text-sm font-bold uppercase tracking-widest text-slate-400">Status Transaksi</h3>
                        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                            <div class="p-3 rounded-lg border border-slate-100">
                                <p class="text-[10px] font-bold uppercase text-slate-400">Tanggal Pinjam</p>
                                <p class="mt-1 text-sm font-semibold text-slate-900" x-text="detailPeminjaman.tanggal_pinjam"></p>
                            </div>
                            <div class="p-3 rounded-lg border border-slate-100">
                                <p class="text-[10px] font-bold uppercase text-slate-400">Jatuh Tempo</p>
                                <p class="mt-1 text-sm font-semibold text-rose-600" x-text="detailPeminjaman.tanggal_jatuh_tempo"></p>
                            </div>
                            <div class="p-3 rounded-lg border border-slate-100">
                                <p class="text-[10px] font-bold uppercase text-slate-400">Tanggal Kembali</p>
                                <p class="mt-1 text-sm font-semibold text-emerald-600" x-text="detailPeminjaman.tanggal_kembali || '-'"></p>
                            </div>
                            <div class="p-3 rounded-lg border border-slate-100">
                                <p class="text-[10px] font-bold uppercase text-slate-400">Denda Terakumulasi</p>
                                <p class="mt-1 text-sm font-bold text-slate-900" x-text="detailPeminjaman.jumlah_denda"></p>
                            </div>
                        </div>
                        
                        <div class="flex items-center justify-between p-4 rounded-xl bg-slate-900 text-white shadow-lg">
                            <span class="text-sm font-medium tracking-wide">Status Peminjaman Saat Ini</span>
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-tighter"
                                :class="{
                                    'bg-amber-400 text-amber-950': detailPeminjaman.status_value === 'dipinjam',
                                    'bg-rose-500 text-white': detailPeminjaman.status_value === 'terlambat',
                                    'bg-emerald-500 text-white': detailPeminjaman.status_value === 'dikembalikan'
                                }"
                                x-text="detailPeminjaman.status_label">
                            </span>
                        </div>
                    </div>
                </div>
            </template>
        </x-ui.modal>
    </div>
</x-layouts.app>
