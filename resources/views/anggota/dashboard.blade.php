<x-layouts.auth :title="'Dashboard Anggota Libris'">
    <div class="w-full space-y-8">
        <div class="flex flex-col gap-4 rounded-[2rem] border border-white/10 bg-white/8 p-8 backdrop-blur-xl md:flex-row md:items-center md:justify-between">
            <div class="space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Dashboard Anggota</p>
                <h1 class="text-4xl text-stone-50">Halo, {{ auth()->user()->name }}</h1>
                <p class="max-w-2xl text-stone-300">
                    Fase 4 aktif. Akun anggota sudah diarahkan ke area terpisah dan dibatasi dari halaman admin. Fase modul katalog dan riwayat peminjaman akan dibangun berikutnya.
                </p>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
                    Logout
                </button>
            </form>
        </div>

        <div class="grid gap-4 md:grid-cols-3">
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">Peran</p>
                <p class="mt-3 text-3xl text-stone-50">Anggota</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">NIM</p>
                <p class="mt-3 text-xl text-stone-50">{{ auth()->user()->nim }}</p>
            </div>
            <div class="rounded-3xl border border-white/10 bg-stone-900/70 p-6">
                <p class="text-sm uppercase tracking-[0.18em] text-stone-400">Akses</p>
                <p class="mt-3 text-xl text-stone-50">Area Anggota Saja</p>
            </div>
        </div>
    </div>
</x-layouts.auth>
