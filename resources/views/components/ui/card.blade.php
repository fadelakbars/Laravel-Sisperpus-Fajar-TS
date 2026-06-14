@props([
    'title' => null,
    'description' => null,
    'padding' => 'p-6'
])

<div {{ $attributes->merge(['class' => 'overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm']) }}>
    @if($title || $description)
        <div class="border-b border-slate-100 px-6 py-4">
            @if($title)
                <h3 class="text-lg font-semibold leading-6 text-slate-900">{{ $title }}</h3>
            @endif
            @if($description)
                <p class="mt-1 text-sm text-slate-500">{{ $description }}</p>
            @endif
        </div>
    @endif
    <div class="{{ $padding }}">
        {{ $slot }}
    </div>
</div>
