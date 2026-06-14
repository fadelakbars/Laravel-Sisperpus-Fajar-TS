<x-layouts.auth :title="'Edit Buku Libris'">
    <div class="w-full space-y-8">
        <div class="space-y-2 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Buku</p>
            <h1 class="text-4xl text-stone-50">Edit Buku</h1>
            <p class="max-w-2xl text-stone-300">
                Perbarui data buku <span class="text-stone-100">{{ $buku->judul }}</span> sesuai katalog terbaru.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.buku.update', $buku) }}" class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            @method('PUT')
            @include('admin.buku._form', ['tombol' => 'Perbarui Buku'])
        </form>
    </div>
</x-layouts.auth>
