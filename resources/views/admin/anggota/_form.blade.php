@csrf

<div class="grid gap-6 md:grid-cols-2">
    <div class="space-y-2">
        <label for="name" class="text-sm text-stone-300">Nama</label>
        <input id="name" name="name" type="text" value="{{ old('name', $anggota->name ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('name')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="email" class="text-sm text-stone-300">Email</label>
        <input id="email" name="email" type="email" value="{{ old('email', $anggota->email ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('email')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="nim" class="text-sm text-stone-300">NIM</label>
        <input id="nim" name="nim" type="text" value="{{ old('nim', $anggota->nim ?? '') }}" required class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('nim')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2">
        <label for="password" class="text-sm text-stone-300">Kata Sandi</label>
        <input id="password" name="password" type="password" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
        @error('password')
            <p class="text-sm text-rose-300">{{ $message }}</p>
        @enderror
    </div>

    <div class="space-y-2 md:col-span-2">
        <label for="password_confirmation" class="text-sm text-stone-300">Konfirmasi Kata Sandi</label>
        <input id="password_confirmation" name="password_confirmation" type="password" {{ $mode === 'create' ? 'required' : '' }} class="w-full rounded-2xl border border-white/10 bg-black/25 px-4 py-3 text-stone-50 outline-none placeholder:text-stone-500 focus:border-amber-300/60">
    </div>
</div>

<div class="mt-8 flex flex-wrap gap-3">
    <button class="rounded-2xl bg-amber-300 px-5 py-3 text-sm font-semibold uppercase tracking-[0.18em] text-stone-950 transition hover:bg-amber-200">
        {{ $tombol }}
    </button>
    <a href="{{ route('admin.anggota.index') }}" class="rounded-2xl border border-white/15 px-5 py-3 text-sm uppercase tracking-[0.18em] text-stone-100 transition hover:border-amber-300/50 hover:text-amber-200">
        Batal
    </a>
</div>
