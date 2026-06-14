<x-layouts.auth :title="'Edit Anggota Libris'">
    <div class="w-full space-y-8">
        <div class="space-y-2 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl">
            <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Admin Anggota</p>
            <h1 class="text-4xl text-stone-50">Edit Anggota</h1>
            <p class="max-w-2xl text-stone-300">
                Perbarui data akun anggota <span class="text-stone-100">{{ $anggota->name }}</span>.
            </p>
        </div>

        <form method="POST" action="{{ route('admin.anggota.update', $anggota) }}" class="rounded-[2rem] border border-white/10 bg-stone-900/70 p-8">
            @method('PUT')
            @include('admin.anggota._form', ['tombol' => 'Perbarui Anggota', 'mode' => 'edit'])
        </form>
    </div>
</x-layouts.auth>
