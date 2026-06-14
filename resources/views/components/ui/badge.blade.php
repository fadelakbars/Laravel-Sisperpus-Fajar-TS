@props([
    'variant' => 'neutral'
])

@php
    $baseClasses = 'inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold uppercase tracking-wider transition-colors duration-200';
    
    $variants = [
        'neutral' => 'bg-slate-100 text-slate-700 border border-slate-200',
        'primary' => 'bg-indigo-50 text-indigo-700 border border-indigo-200',
        'success' => 'bg-emerald-50 text-emerald-700 border border-emerald-200',
        'danger' => 'bg-rose-50 text-rose-700 border border-rose-200',
        'warning' => 'bg-amber-50 text-amber-700 border border-amber-200',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['neutral']);
@endphp

<span {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</span>
