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
    
    <div 
        class="relative" 
        @if($type === 'password') x-data="{ show: false }" @endif
    >
        <input 
            @if($type === 'password') 
                :type="show ? 'text' : 'password'" 
            @else 
                type="{{ $type }}" 
            @endif
            id="{{ $name }}" 
            name="{{ $name }}" 
            value="{{ $value ?? old($name) }}"
            placeholder="{{ $placeholder }}"
            @if($required) required @endif
            {{ $attributes->merge(['class' => 'block w-full rounded-lg border-slate-200 bg-white px-4 py-2.5 text-slate-900 shadow-sm transition duration-200 placeholder:text-slate-400 focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm border']) }}
        >

        @if($type === 'password')
            <button 
                type="button" 
                @click="show = !show" 
                class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600 transition-colors"
            >
                <!-- Eye Open -->
                <svg x-show="!show" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c3.54 0 6.623 1.777 8.526 4.633.305.459.305 1.054 0 1.513C18.623 13.51 15.54 16.5 12 16.5c-3.54 0-6.623-1.777-8.526-4.633z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                </svg>
                <!-- Eye Closed -->
                <svg x-show="show" x-cloak class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                </svg>
            </button>
        @endif
    </div>

    @error($name)
        <p class="text-sm text-rose-600 font-medium">{{ $message }}</p>
    @enderror
</div>
