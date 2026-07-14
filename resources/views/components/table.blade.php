@props([
    'class' => '',
])

<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">
    <table {{ $attributes->merge(['class' => "min-w-full divide-y divide-slate-200 $class"]) }}>
        {{ $slot }}
    </table>
</div>
