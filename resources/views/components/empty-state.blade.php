@props([
    'title' => 'No data available',
    'description' => '',
    'icon' => null,
])

<div
    {{ $attributes->merge(['class' => 'flex flex-col items-center justify-center rounded-2xl border border-dashed border-slate-300 bg-slate-50 px-8 py-12 text-center']) }}>
    @if ($icon)
        <div class="mb-4 text-slate-400">
            {!! $icon !!}
        </div>
    @endif

    <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>

    @if ($description)
        <p class="mt-2 max-w-md text-sm text-slate-500">{{ $description }}</p>
    @endif

    @if ($slot->isNotEmpty())
        <div class="mt-4">
            {{ $slot }}
        </div>
    @endif
</div>
