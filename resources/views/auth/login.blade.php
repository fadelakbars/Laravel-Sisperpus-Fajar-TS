<x-layouts.auth :title="'Login - Libris'">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center">
            <span class="text-4xl font-bold tracking-tight text-indigo-600 font-serif italic">Libris</span>
        </div>
        <h2 class="mt-6 text-center text-2xl font-bold leading-9 tracking-tight text-slate-900">
            Masuk ke Akun Anda
        </h2>
        <p class="mt-2 text-center text-sm text-slate-500">
            Gunakan kredensial yang telah disediakan oleh administrator.
        </p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-[480px]">
        <div class="bg-white px-6 py-12 shadow-sm border border-slate-200 sm:rounded-2xl sm:px-12">
            <form class="space-y-6" action="{{ route('login.store') }}" method="POST">
                @csrf
                
                <x-ui.input 
                    label="Alamat Email" 
                    name="email" 
                    type="email" 
                    placeholder="nama@kampus.ac.id" 
                    required 
                    autofocus
                />

                <x-ui.input 
                    label="Kata Sandi" 
                    name="password" 
                    type="password" 
                    placeholder="Masukkan kata sandi" 
                    required 
                />

                <div class="flex items-center justify-between">
                    <div class="flex items-center">
                        <input id="remember_me" name="remember" type="checkbox" class="h-4 w-4 rounded border-slate-300 text-indigo-600 focus:ring-indigo-600">
                        <label for="remember_me" class="ml-3 block text-sm leading-6 text-slate-700">Ingat saya</label>
                    </div>
                </div>

                <div>
                    <x-ui.button type="submit" class="w-full">
                        Masuk
                    </x-ui.button>
                </div>
            </form>

            <div class="mt-10">
                <div class="relative">
                    <div class="absolute inset-0 flex items-center" aria-hidden="true">
                        <div class="w-full border-t border-slate-200"></div>
                    </div>
                    <div class="relative flex justify-center text-sm font-medium leading-6">
                        <span class="bg-white px-6 text-slate-400 font-normal">Kredensial Demo</span>
                    </div>
                </div>

                <div class="mt-6 grid grid-cols-1 gap-4 text-sm">
                    <div class="rounded-lg bg-slate-50 p-4 border border-slate-100">
                        <div class="flex flex-col gap-1">
                            <p class="text-slate-600">Admin: <span class="font-semibold text-indigo-600">admin@libris.test</span></p>
                            <p class="text-slate-600">Anggota: <span class="font-semibold text-indigo-600">anggota@libris.test</span></p>
                            <p class="text-slate-400 mt-1 text-xs">Password: <span class="italic">password</span></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <p class="mt-10 text-center text-sm text-slate-400">
            &copy; {{ date('Y') }} Libris Sisperpus. All rights reserved.
        </p>
    </div>
</x-layouts.auth>
