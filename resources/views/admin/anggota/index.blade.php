<x-layouts.app :title="'Manajemen Anggota - Libris'">
    <div class="space-y-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Data Anggota</h1>
                <p class="mt-1 text-sm text-slate-500">Kelola informasi mahasiswa dan akun akses perpustakaan.</p>
            </div>
            <div>
                <x-ui.button type="link" href="{{ route('admin.anggota.create') }}">
                    <svg class="-ml-0.5 mr-1.5 h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 3a1 1 0 011 1v5h5a1 1 0 110 2h-5v5a1 1 0 11-2 0v-5H4a1 1 0 110-2h5V4a1 1 0 011-1z" clip-rule="evenodd" />
                    </svg>
                    Tambah Anggota
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
                <form method="GET" action="{{ route('admin.anggota.index') }}" class="flex max-w-sm gap-2">
                    <x-ui.input 
                        name="cari" 
                        :value="$kataKunci" 
                        placeholder="Cari nama, NIM, atau email..." 
                        class="py-1.5"
                    />
                    <x-ui.button type="submit" variant="secondary" class="py-1.5">Cari</x-ui.button>
                </form>
            </div>
            
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Anggota</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Email</th>
                            <th class="px-6 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">Peran</th>
                            <th class="px-6 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-200 bg-white">
                        @forelse ($daftarAnggota as $anggota)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-slate-900">{{ $anggota->name }}</div>
                                    <div class="text-xs text-slate-500">NIM: {{ $anggota->nim ?? '-' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-slate-600">{{ $anggota->email }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <x-ui.badge :variant="$anggota->peran->value === 'admin' ? 'primary' : 'neutral'">
                                        {{ ucfirst($anggota->peran->value) }}
                                    </x-ui.badge>
                                </td>
                                <td class="px-6 py-4 text-right whitespace-nowrap">
                                    <div class="flex justify-end gap-3">
                                        <a href="{{ route('admin.anggota.edit', $anggota) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-900 transition">
                                            Edit
                                        </a>
                                        <form method="POST" action="{{ route('admin.anggota.destroy', $anggota) }}" onsubmit="return confirm('Hapus anggota ini?');">
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
                                <td colspan="4" class="px-6 py-10 text-center text-sm text-slate-400 italic">Belum ada data anggota.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $daftarAnggota->links() }}
            </div>
        </x-ui.card>
    </div>
</x-layouts.app>
