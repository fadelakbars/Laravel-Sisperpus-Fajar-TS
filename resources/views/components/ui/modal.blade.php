@props([
    'name',
    'title' => null,
])

<div
    x-data="{ show: false }"
    x-show="show"
    x-on:open-modal.window="if ($event.detail.name === '{{ $name }}') show = true"
    x-on:close-modal.window="if ($event.detail.name === '{{ $name }}') show = false"
    x-on:keydown.escape.window="show = false"
    style="display: none;"
    class="fixed inset-0 z-[60] overflow-y-auto px-4 py-6 sm:px-0"
>
    <!-- Background backdrop -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100"
        x-transition:leave-end="opacity-0"
        class="fixed inset-0 transform transition-all"
        x-on:click="show = false"
    >
        <div class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm"></div>
    </div>

    <!-- Modal content -->
    <div
        x-show="show"
        x-transition:enter="ease-out duration-300"
        x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
        x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
        class="mb-6 transform overflow-hidden rounded-2xl bg-white shadow-xl transition-all sm:mx-auto sm:w-full sm:max-w-2xl"
    >
        @if($title)
            <div class="border-b border-slate-100 px-6 py-4 flex items-center justify-between bg-slate-50/50">
                <h3 class="text-lg font-bold text-slate-900">{{ $title }}</h3>
                <button x-on:click="show = false" class="text-slate-400 hover:text-slate-600 transition">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        @endif

        <div class="p-6">
            {{ $slot }}
        </div>
    </div>
</div>
