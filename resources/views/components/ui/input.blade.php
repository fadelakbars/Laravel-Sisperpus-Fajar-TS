@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => null,
    'required' => false
])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="text-sm font-medium text-slate-700">
            {{ $label }} @if($required)<span class="text-rose-500">*</span>@endif
        </label>
    @endif
    
    <div class="relative">
        <input 
            type="{{ $type }}" 
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ $value ?? old($name) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border']) }}
        >
    </div>

    @error($name)
        <p class="text-sm text-rose-600 font-medium">{{ $message }}</p>
    @enderror
</div>
