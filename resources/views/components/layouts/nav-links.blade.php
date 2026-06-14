@if (auth()->user()->adalahAdmin())
    <li>
        <a href="{{ route('admin.dashboard') }}" class="@if(request()->routeIs('admin.dashboard')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('admin.dashboard')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('admin.buku.index') }}" class="@if(request()->routeIs('admin.buku.*')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('admin.buku.*')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            Katalog Buku
        </a>
    </li>
    <li>
        <a href="{{ route('admin.anggota.index') }}" class="@if(request()->routeIs('admin.anggota.*')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('admin.anggota.*')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z" />
            </svg>
            Data Anggota
        </a>
    </li>
    <li>
        <a href="{{ route('admin.peminjaman.index') }}" class="@if(request()->routeIs('admin.peminjaman.*')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('admin.peminjaman.*')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M7.5 21L3 16.5m0 0L7.5 12M3 16.5h13.5m0-13.5L21 7.5m0 0L16.5 12M21 7.5H7.5" />
            </svg>
            Sirkulasi
        </a>
    </li>
@else
    <li>
        <a href="{{ route('anggota.dashboard') }}" class="@if(request()->routeIs('anggota.dashboard')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('anggota.dashboard')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12l8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
            </svg>
            Dashboard
        </a>
    </li>
    <li>
        <a href="{{ route('anggota.buku.index') }}" class="@if(request()->routeIs('anggota.buku.index')) bg-slate-50 text-indigo-600 @else text-slate-700 hover:text-indigo-600 hover:bg-slate-50 @endif group flex gap-x-3 rounded-md p-2 text-sm leading-6 font-semibold transition">
            <svg class="h-6 w-6 shrink-0 @if(request()->routeIs('anggota.buku.index')) text-indigo-600 @else text-slate-400 group-hover:text-indigo-600 @endif" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" />
            </svg>
            Katalog Buku
        </a>
    </li>
@endif
