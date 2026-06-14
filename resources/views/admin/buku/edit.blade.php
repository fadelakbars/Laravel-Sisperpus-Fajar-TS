<x-layouts.app :title="'Edit Buku - Libris'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Edit Data Buku</h1>
            <p class="mt-1 text-sm text-slate-500">Perbarui informasi bibliografi atau stok buku.</p>
        </div>

        <x-ui.card>
            <form action="{{ route('admin.buku.update', $buku) }}" method="POST">
                @csrf
                @method('PUT')
                @include('admin.buku._form')
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
