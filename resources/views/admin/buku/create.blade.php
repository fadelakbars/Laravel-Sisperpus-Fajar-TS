<x-layouts.app :title="'Tambah Buku - Sisperpus'">
    <div class="max-w-3xl mx-auto space-y-6">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Tambah Buku Baru</h1>
            <p class="mt-1 text-sm text-slate-500">Masukkan data bibliografi buku untuk menambahkannya ke katalog.</p>
        </div>

        <x-ui.card>
            <form action="{{ route('admin.buku.store') }}" method="POST">
                @csrf
                @include('admin.buku._form')
            </form>
        </x-ui.card>
    </div>
</x-layouts.app>
