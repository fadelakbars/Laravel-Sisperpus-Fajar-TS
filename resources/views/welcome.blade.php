<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-slate-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Libris - Sistem Perpustakaan Kampus</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full font-sans antialiased text-slate-900">
    <div class="relative isolate overflow-hidden bg-white min-h-full">
        <svg class="absolute inset-0 -z-10 h-full w-full stroke-slate-200 [mask-image:radial-gradient(100%_100%_at_top_right,white,transparent)]" aria-hidden="true">
            <defs>
                <pattern id="0757a34b-1b95-4cfd-847e-7e951b31d06c" width="200" height="200" x="50%" y="-1" patternUnits="userSpaceOnUse">
                    <path d="M.5 200V.5H200" fill="none" />
                </pattern>
            </defs>
            <rect width="100%" height="100%" stroke-width="0" fill="url(#0757a34b-1b95-4cfd-847e-7e951b31d06c)" />
        </svg>
        
        <div class="mx-auto max-w-7xl px-6 pb-24 pt-10 sm:pb-32 lg:flex lg:px-8 lg:py-40">
            <div class="mx-auto max-w-2xl lg:mx-0 lg:max-w-xl lg:flex-shrink-0 lg:pt-8">
                <div class="mt-24 sm:mt-32 lg:mt-16">
                    <a href="#" class="inline-flex space-x-6">
                        <span class="rounded-full bg-indigo-600/10 px-3 py-1 text-sm font-semibold leading-6 text-indigo-600 ring-1 ring-inset ring-indigo-600/10">Sistem Perpustakaan</span>
                        <span class="inline-flex items-center space-x-2 text-sm font-medium leading-6 text-slate-600">
                            <span>v1.2.0 Stable</span>
                        </span>
                    </a>
                </div>
                <h1 class="mt-10 text-4xl font-bold tracking-tight text-slate-900 sm:text-6xl font-serif">Libris.</h1>
                <p class="mt-6 text-lg leading-8 text-slate-600">Kelola katalog buku, sirkulasi peminjaman, dan data anggota dalam satu sistem yang rapi, modern, dan sangat mudah digunakan.</p>
                <div class="mt-10 flex items-center gap-x-6">
                    <a href="{{ route('login') }}" class="rounded-lg bg-indigo-600 px-5 py-3 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                        Masuk ke Aplikasi
                    </a>
                    <a href="#" class="text-sm font-semibold leading-6 text-slate-900">Pelajari Fitur <span aria-hidden="true">→</span></a>
                </div>
            </div>
            <div class="mx-auto mt-16 flex max-w-2xl sm:mt-24 lg:ml-10 lg:mr-0 lg:mt-0 lg:max-w-none lg:flex-none xl:ml-32">
                <div class="max-w-3xl flex-none sm:max-w-5xl lg:max-w-none">
                    <div class="-m-2 rounded-xl bg-slate-900/5 p-2 ring-1 ring-inset ring-slate-900/10 lg:-m-4 lg:rounded-2xl lg:p-4">
                        <div class="bg-white rounded-lg shadow-2xl ring-1 ring-slate-900/10 p-8 space-y-6 w-[400px]">
                            <div class="h-4 w-1/3 bg-slate-100 rounded"></div>
                            <div class="h-8 w-3/4 bg-indigo-50 rounded"></div>
                            <div class="space-y-3">
                                <div class="h-4 w-full bg-slate-50 rounded"></div>
                                <div class="h-4 w-full bg-slate-50 rounded"></div>
                                <div class="h-4 w-2/3 bg-slate-50 rounded"></div>
                            </div>
                            <div class="grid grid-cols-3 gap-4">
                                <div class="h-10 bg-slate-100 rounded-lg"></div>
                                <div class="h-10 bg-slate-100 rounded-lg"></div>
                                <div class="h-10 bg-indigo-100 rounded-lg"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
