<div class="grid grid-cols-1 gap-6 sm:grid-cols-2">
    <x-ui.input label="Nama Lengkap" name="name" :value="$anggota->name ?? null" placeholder="Nama mahasiswa" required />

    <x-ui.input label="NIM" name="nim" :value="$anggota->nim ?? null" placeholder="Nomor Induk Mahasiswa" />

    <x-ui.input label="Alamat Email" name="email" type="email" :value="$anggota->email ?? null" placeholder="email@mahasiswa.ac.id"
        required />

    <x-ui.input label="Kata Sandi" name="password" type="password"
        placeholder="{{ isset($anggota) ? 'Kosongkan jika tidak ingin diubah' : 'Masukkan kata sandi' }}"
        :required="!isset($anggota)" />

    <div class="space-y-1.5">
        <label for="peran" class="text-sm font-medium text-slate-700">Peran Pengguna</label>
        <select name="peran" id="peran"
            class="block w-full rounded-lg border border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
            <option value="anggota" @selected(($anggota?->peran?->value ?? 'anggota') === 'anggota')>Anggota</option>
            <option value="admin" @selected(($anggota?->peran?->value ?? '') === 'admin')>Admin</option>
        </select>
    </div>

    <x-ui.input label="Konfirmasi Kata Sandi" name="password_confirmation" type="password"
        placeholder="Ulangi kata sandi" :required="!isset($anggota)" />
</div>

<div class="mt-8 flex items-center justify-end gap-3">
    <x-ui.button type="link" href="{{ route('admin.anggota.index') }}" variant="secondary">
        Batal
    </x-ui.button>
    <x-ui.button type="submit">
        {{ isset($anggota) ? 'Simpan Perubahan' : 'Tambah Anggota' }}
    </x-ui.button>
</div>
