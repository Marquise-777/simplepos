@props([
    'id' => 'modal',
    'title' => '',
    'class' => '',
])

<div id="{{ $id }}" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-900/50 px-4">
    <div
        {{ $attributes->merge(['class' => "w-full max-w-lg rounded-2xl border border-slate-200 bg-white p-6 shadow-xl $class"]) }}>
        @if ($title)
            <div class="mb-4">
                <h3 class="text-lg font-semibold text-slate-900">{{ $title }}</h3>
            </div>
        @endif

        {{ $slot }}
    </div>
</div>
