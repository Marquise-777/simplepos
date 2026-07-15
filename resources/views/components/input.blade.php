@props([
    'label' => null,
    'name' => null,
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
])

@php
    $inputValue = $name ? old($name, $value) : $value;

    if (is_array($inputValue)) {
        $inputValue = '';
    }
@endphp

<div class="space-y-2">

    @if ($label)
        <label @if ($name) for="{{ $name }}" @endif
            class="block text-sm font-medium text-slate-700">

            {{ $label }}

            @if ($required)
                <span class="text-red-500">*</span>
            @endif

        </label>
    @endif

    <div x-data="{ show: false }" class="relative">

        <input
            @if ($name) id="{{ $name }}"
                name="{{ $name }}" @endif
            @if ($type === 'password') :type="show ? 'text' : 'password'"
            @else
                type="{{ $type }}" @endif
            value="{{ $inputValue }}" placeholder="{{ $placeholder }}" @required($required) @disabled($disabled)
            {{ $attributes->merge([
                'class' =>
                    'w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 placeholder:text-slate-400 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100' .
                    ($type === 'password' ? ' pr-12' : ''),
            ]) }}>

        @if ($type === 'password')
            <button type="button" @click="show = !show"
                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-slate-700">

                {{-- Eye --}}
                <svg x-show="!show" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0" />

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />

                </svg>

                {{-- Eye Off --}}
                <svg x-show="show" x-cloak xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">

                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.542-7a9.956 9.956 0 012.223-3.592M6.223 6.223A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.542 7a9.965 9.965 0 01-4.293 5.182M3 3l18 18" />

                </svg>

            </button>
        @endif

    </div>

    @if ($name)
        @error($name)
            <p class="text-sm text-red-500">
                {{ $message }}
            </p>
        @enderror
    @endif

</div>
