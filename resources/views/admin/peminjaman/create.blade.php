<x-layouts.app :title="'Catat Peminjaman - Sisperpus'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Peminjaman Baru</h1>
            <p class="mt-1 text-sm text-slate-500">Pilih buku dan anggota untuk memulai transaksi peminjaman.</p>
        </div>

        @if ($errors->any())
            <div class="rounded-lg border border-rose-200 bg-rose-50 p-4 text-sm text-rose-700">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <x-ui.card>
            <form action="{{ route('admin.peminjaman.store') }}" method="POST" class="space-y-6">
                @csrf

                <div class="space-y-1.5">
                    <label for="anggota_id" class="text-sm font-medium text-slate-700">Pilih Anggota</label>
                    <select 
                        name="anggota_id" 
                        id="anggota_id" 
                        required
                        class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">-- Pilih Anggota --</option>
                        @foreach ($daftarAnggota as $anggota)
                            <option value="{{ $anggota->id }}" @selected(old('anggota_id') == $anggota->id)>
                                {{ $anggota->name }} (NIM: {{ $anggota->nim ?? '-' }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="space-y-1.5">
                    <label for="buku_id" class="text-sm font-medium text-slate-700">Pilih Buku</label>
                    <select 
                        name="buku_id" 
                        id="buku_id" 
                        required
                        class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                    >
                        <option value="">-- Pilih Buku --</option>
                        @foreach ($daftarBuku as $buku)
                            <option value="{{ $buku->id }}" @selected(old('buku_id') == $buku->id) @disabled($buku->stok <= 0)>
                                {{ $buku->judul }} (Stok: {{ $buku->stok }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
                    <x-ui.input 
                        label="Tanggal Pinjam" 
                        name="tanggal_pinjam" 
                        type="date" 
                        :value="old('tanggal_pinjam', date('Y-m-d'))" 
                        required 
                    />

                    <x-ui.input 
                        label="Tanggal Jatuh Tempo" 
                        name="tanggal_jatuh_tempo" 
                        type="date" 
                        :value="old('tanggal_jatuh_tempo', date('Y-m-d', strtotime('+7 days')))" 
                        required 
                    />
                </div>

                <div class="mt-8 flex items-center justify-end gap-3 border-t border-slate-100 pt-6">
                    <x-ui.button type="link" href="{{ route('admin.peminjaman.index') }}" variant="secondary">
                        Batal
                    </x-ui.button>
                    <x-ui.button type="submit">
                        Simpan Transaksi
                    </x-ui.button>
                </div>
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
