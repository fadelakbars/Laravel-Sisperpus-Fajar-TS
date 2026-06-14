<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ $title ?? config('app.name', 'Libris') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-stone-950 text-stone-100">
        <div class="relative min-h-screen overflow-hidden">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_left,_rgba(234,179,8,0.18),_transparent_32%),radial-gradient(circle_at_bottom_right,_rgba(249,115,22,0.18),_transparent_28%),linear-gradient(135deg,_#1c1917,_#0c0a09_58%,_#111827)]"></div>
            <div class="absolute inset-0 bg-[linear-gradient(rgba(255,255,255,0.03)_1px,transparent_1px),linear-gradient(90deg,rgba(255,255,255,0.03)_1px,transparent_1px)] bg-[size:32px_32px]"></div>

            <main class="relative mx-auto flex min-h-screen w-full max-w-7xl items-center px-6 py-12 lg:px-10">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
