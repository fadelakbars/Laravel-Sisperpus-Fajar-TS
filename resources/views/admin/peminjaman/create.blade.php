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
            <form action="{{ route('admin.peminjaman.store') }}" method="POST" 
                x-data="{ 
                    selectedBooks: [],
                    availableBooks: @js($daftarBuku->map(fn($b) => ['id' => $b->id, 'judul' => $b->judul, 'stok' => $b->stok])),
                    currentBookId: '',
                    
                    addBook() {
                        if (!this.currentBookId) return;
                        
                        const book = this.availableBooks.find(b => b.id == this.currentBookId);
                        if (book && !this.selectedBooks.find(b => b.id == book.id)) {
                            this.selectedBooks.push(book);
                        }
                        this.currentBookId = '';
                    },
                    
                    removeBook(id) {
                        this.selectedBooks = this.selectedBooks.filter(b => b.id !== id);
                    }
                }"
                class="space-y-6"
            >
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

                <div class="space-y-4 rounded-xl border border-slate-100 bg-slate-50/50 p-4">
                    <div class="flex items-end gap-3">
                        <div class="flex-1 space-y-1.5">
                            <label for="book_selector" class="text-sm font-medium text-slate-700">Pilih Buku untuk Dipinjam</label>
                            <select 
                                id="book_selector" 
                                x-model="currentBookId"
                                class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm"
                            >
                                <option value="">-- Pilih Buku --</option>
                                <template x-for="book in availableBooks" :key="book.id">
                                    <option :value="book.id" x-text="book.judul + ' (Stok: ' + book.stok + ')'" :disabled="book.stok <= 0"></option>
                                </template>
                            </select>
                        </div>
                        <x-ui.button type="button" @click="addBook()" variant="secondary" class="mb-0.5">
                            Tambah
                        </x-ui.button>
                    </div>

                    <div class="space-y-2">
                        <p class="text-xs font-bold uppercase tracking-widest text-slate-400">Daftar Buku Terpilih</p>
                        
                        <div class="min-h-[100px] rounded-lg border border-dashed border-slate-200 bg-white">
                            <template x-if="selectedBooks.length === 0">
                                <div class="flex h-[100px] items-center justify-center text-sm text-slate-400 italic">
                                    Belum ada buku yang dipilih.
                                </div>
                            </template>

                            <ul class="divide-y divide-slate-100">
                                <template x-for="book in selectedBooks" :key="book.id">
                                    <li class="flex items-center justify-between px-4 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-sm font-semibold text-slate-900" x-text="book.judul"></span>
                                            <span class="text-xs text-slate-500" x-text="'Stok tersedia: ' + book.stok"></span>
                                            <input type="hidden" name="buku_ids[]" :value="book.id">
                                        </div>
                                        <button type="button" @click="removeBook(book.id)" class="text-rose-500 hover:text-rose-700 transition p-1">
                                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                                            </svg>
                                        </button>
                                    </li>
                                </template>
                            </ul>
                        </div>
                    </div>
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
