@props([
    'size' => 'md',
    'src' => null,
    'label' => '',
    'class' => '',
])

@php
    $sizes = [
        'sm' => 'h-8 w-8 text-xs',
        'md' => 'h-10 w-10 text-sm',
        'lg' => 'h-12 w-12 text-base',
    ];
@endphp

<div {{ $attributes->merge(['class' => "flex items-center justify-center overflow-hidden rounded-full bg-slate-200 font-semibold text-slate-700 {$sizes[$size] ?? $sizes['md']} $class"]) }}>
    @if ($src)
        <img src="{{ $src }}" alt="{{ $label }}" class="h-full w-full object-cover" />
    @else
        <span>{{ Str::upper(Str::limit($label, 2, '')) }}</span>
    @endif
</div>
