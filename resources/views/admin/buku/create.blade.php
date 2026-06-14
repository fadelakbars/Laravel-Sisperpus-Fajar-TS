<x-layouts.auth :title="'Tambah Buku Libris'">
    <div class="w-full space-y-8">
        <div class="space-y-2 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Buku</p>
            <h1 class="text-4xl text-stone-50">Tambah Buku Baru</h1>
            <p class="max-w-2xl text-stone-300">
                Masukkan data katalog buku secara lengkap agar siap digunakan pada modul sirkulasi.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.buku.store') }}" class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            @include('admin.buku._form', ['tombol' => 'Simpan Buku'])
        </form>
    </div>
</x-layouts.auth>
