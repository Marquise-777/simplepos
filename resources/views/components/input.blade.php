@props([
    'label' => null,
    'name',
    'type' => 'text',
    'placeholder' => '',
    'value' => '',
    'required' => false,
    'disabled' => false,
])

<div class="space-y-2">
    @if ($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-slate-700">
            {{ $label }}

            @if ($required)
                <span class="text-red-500">*</span>
            @endif
        </label>
    @endif

    <input id="{{ $name }}" name="{{ $name }}" type="{{ $type }}" value="{{ old($name, $value) }}"
        placeholder="{{ $placeholder }}" @required($required) @disabled($disabled)
        {{ $attributes->merge([
            'class' => '
                        w-full
                        rounded-2xl
                        border
                        border-slate-200
                        bg-white
                        px-4
                        py-3
                        text-slate-700
                        placeholder:text-slate-400
                        shadow-sm
                        transition
                        focus:border-blue-500
                        focus:ring-4
                        focus:ring-blue-100
                    ',
        ]) }}>

    @error($name)
        <p class="text-sm text-red-500">
            {{ $message }}
        </p>
    @enderror
</div>
