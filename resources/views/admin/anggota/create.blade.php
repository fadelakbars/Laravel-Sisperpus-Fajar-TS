<x-layouts.auth :title="'Tambah Anggota Libris'">
    <div class="w-full space-y-8">
        <div class="space-y-2 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Anggota</p>
            <h1 class="text-4xl text-stone-50">Tambah Anggota Baru</h1>
            <p class="max-w-2xl text-stone-300">
                Buat akun anggota agar dapat mengakses katalog dan riwayat peminjaman pribadi.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.anggota.store') }}" class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            @include('admin.anggota._form', ['tombol' => 'Simpan Anggota', 'mode' => 'create'])
        </form>
    </div>
</x-layouts.auth>
