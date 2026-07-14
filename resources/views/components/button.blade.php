@props([
    'variant' => 'primary',
    'size' => 'md',
    'type' => 'button',
    'full' => false,
])

@php
    $base =
        'inline-flex items-center justify-center rounded-2xl font-semibold transition-all duration-200 focus:outline-none focus:ring-4 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' =>
            'mt-5 w-full rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 py-3 font-medium text-white transition hover:scale-[1.02]',

        'secondary' =>
            'mt-5 w-full rounded-2xl bg-gradient-to-r from-slate-600 to-slate-500 py-3 font-medium text-white transition hover:scale-[1.02]',

        'success' =>
            'mt-5 w-full rounded-2xl bg-gradient-to-r from-emerald-600 to-green-500 py-3 font-medium text-white transition hover:scale-[1.02]',

        'danger' =>
            'mt-5 w-full rounded-2xl bg-gradient-to-r from-red-600 to-rose-500 py-3 font-medium text-white transition hover:scale-[1.02]',

        'ghost' =>
            'mt-5 w-full border border-slate-200 bg-white text-slate-700 hover:bg-slate-50 hover:border-slate-300 focus:ring-slate-200',
    ];

    $sizes = [
        'sm' => 'px-3 py-2 text-sm',
        'md' => 'px-5 py-2.5 text-sm',
        'lg' => 'px-6 py-3 text-base',
    ];

    $classes = collect([
        $base,
        $variants[$variant] ?? $variants['primary'],
        $sizes[$size] ?? $sizes['md'],
        $full ? 'w-full' : '',
        $attributes->get('class'),
    ])->implode(' ');
@endphp

<button type="{{ $type }}" {{ $attributes->merge([
    'class' => $classes,
]) }}>
    {{ $slot }}
</button>
