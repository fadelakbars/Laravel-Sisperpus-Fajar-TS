<x-layouts.app :title="'Dashboard Admin - Libris'">
    <div class="space-y-8">
        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">Selamat Datang, {{ auth()->user()->name }}</h1>
            <p class="mt-2 text-sm text-slate-500">Berikut adalah ringkasan aktivitas perpustakaan hari ini.</p>
        </div>

        <div class="grid grid-cols-1 gap-6 sm:grid-cols-2 lg:grid-cols-4">
            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-indigo-50 p-2 text-indigo-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Buku</p>
                        <p class="text-2xl font-bold text-slate-900">--</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-emerald-50 p-2 text-emerald-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Anggota</p>
                        <p class="text-2xl font-bold text-slate-900">--</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-amber-50 p-2 text-amber-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Dipinjam</p>
                        <p class="text-2xl font-bold text-slate-900">--</p>
                    </div>
                </div>
            </x-ui.card>

            <x-ui.card padding="p-5">
                <div class="flex items-center gap-x-4">
                    <div class="rounded-lg bg-rose-50 p-2 text-rose-600">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v3.75m9-.75a9 9 0 11-18 0 9 9 0 0118 0zm-9 3.75h.008v.008H12v-.008z" />
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Terlambat</p>
                        <p class="text-2xl font-bold text-slate-900">--</p>
                    </div>
                </div>
            </x-ui.card>
        </div>

        <div class="grid grid-cols-1 gap-6 lg:grid-cols-2">
            <x-ui.card title="Aktivitas Terbaru" description="Daftar transaksi peminjaman terbaru di sistem.">
                <div class="text-center py-10">
                    <p class="text-sm text-slate-400 font-normal italic">Data aktivitas akan muncul di sini.</p>
                </div>
            </x-ui.card>

            <x-ui.card title="Statistik Sistem" description="Status modul dan performa aplikasi.">
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Status Server</span>
                        <x-ui.badge variant="success">Online</x-ui.badge>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Versi Aplikasi</span>
                        <span class="text-sm font-medium text-slate-900 underline decoration-indigo-200">v1.2.0-light</span>
                    </div>
                    <div class="flex items-center justify-between">
                        <span class="text-sm text-slate-600">Fase Implementasi</span>
                        <x-ui.badge variant="primary">Fase 4: UI Refactor</x-ui.badge>
                    </div>
                </div>
            </x-ui.card>
        </div>
    </div>
</x-layouts.app>
