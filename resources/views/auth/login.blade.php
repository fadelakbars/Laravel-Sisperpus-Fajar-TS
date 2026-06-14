<x-layouts.auth :title="'Login Libris'">
    <div class="grid w-full gap-10 lg:grid-cols-[1.15fr_0.85fr] lg:items-center">
        <section class="space-y-6">
            <div class="inline-flex items-center rounded-full border border-amber-300/20 bg-amber-300/10 px-3 py-1 text-sm tracking-[0.18em] text-amber-200 uppercase">
                Sistem Perpustakaan Kampus
            </div>
            <div class="space-y-4">
                <h1 class="max-w-3xl font-serif text-5xl leading-tight text-stone-50 lg:text-6xl">
                    Libris menjaga katalog, anggota, dan sirkulasi tetap rapi dalam satu alur kerja.
                </h1>
                <p class="max-w-2xl text-base leading-7 text-stone-300 lg:text-lg">
                    Masuk menggunakan akun yang sudah disediakan admin untuk mengakses area perpustakaan sesuai peran Anda.
                </p>
            </div>
            <div class="grid gap-4 md:grid-cols-3">
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm uppercase tracking-[0.2em] text-stone-400">Akses</p>
                    <p class="mt-3 text-2xl text-stone-50">Admin & Anggota</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm uppercase tracking-[0.2em] text-stone-400">Otentikasi</p>
                    <p class="mt-3 text-2xl text-stone-50">Session Web</p>
                </div>
                <div class="rounded-3xl border border-white/10 bg-white/5 p-5 backdrop-blur">
                    <p class="text-sm uppercase tracking-[0.2em] text-stone-400">Status</p>
                    <p class="mt-3 text-2xl text-stone-50">Fase 4</p>
                </div>
            </div>
        </section>

        <section class="rounded-[2rem] border border-white/10 bg-white/8 p-8 shadow-2xl shadow-black/30 backdrop-blur-xl">
            <div class="mb-8 space-y-2">
                <p class="text-sm uppercase tracking-[0.22em] text-amber-200">Masuk</p>
                <h2 class="text-3xl text-stone-50">Akses area kerja</h2>
            </div>

            <form method="POST" action="{{ route('login.store') }}" class="space-y-5">
                @csrf

                <div class="space-y-2">
                    <label for="email" class="text-sm text-stone-300">Email</label>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none ring-0 placeholder:text-stone-500 focus:border-amber-300/60"
                        placeholder="nama@kampus.ac.id"
                    >
                    @error('email')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm text-stone-300">Kata sandi</label>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none ring-0 placeholder:text-stone-500 focus:border-amber-300/60"
                        placeholder="Masukkan kata sandi"
                    >
                    @error('password')
                        <p class="text-sm text-rose-300">{{ $message }}</p>
                    @enderror
                </div>

                <label class="flex items-center gap-3 text-sm text-stone-300">
                    <input type="checkbox" name="ingat_saya" class="h-4 w-4 rounded border-white/20 bg-transparent text-amber-300 focus:ring-amber-300">
                    <span>Ingat sesi login saya</span>
                </label>

                <button
                    type="submit"
                    class="inline-flex w-full items-center justify-center rounded-2xl bg-amber-300 px-4 py-3 text-sm font-semibold tracking-[0.18em] text-stone-950 uppercase transition hover:bg-amber-200"
                >
                    Login
                </button>
            </form>

            <div class="mt-8 rounded-2xl border border-white/10 bg-black/20 p-4 text-sm text-stone-300">
                <p>Akun awal seeder:</p>
                <p class="mt-2 text-stone-100">Admin: <span class="text-amber-200">admin@libris.test</span></p>
                <p class="text-stone-100">Anggota: <span class="text-amber-200">anggota@libris.test</span></p>
                <p class="mt-1 text-stone-400">Kata sandi default: <span class="text-stone-200">password</span></p>
            </div>
        </section>
    </div>
</x-layouts.auth>
