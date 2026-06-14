<x-layouts.app :title="'Edit Anggota - Sisperpus'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Anggota</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi profil atau akses anggota.</p>
        </div>

        <x-ui.card>
            <form action="{{ route('admin.anggota.update', $anggota) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.anggota._form')
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
