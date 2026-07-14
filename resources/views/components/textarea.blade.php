@props([
    'class' => '',
])

<textarea
    {{ $attributes->merge(['class' => "w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-900 shadow-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100 $class"]) }}>{{ $slot }}</textarea>
