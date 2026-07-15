@props(['href', 'icon', 'active' => false, 'badge' => null])

@php
    $isActive = request()->routeIs($active);

    $classes = $isActive ? 'bg-blue-50 text-blue-700' : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';
@endphp

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' => "flex items-center gap-3 rounded-2xl px-4 py-3 font-medium transition {$classes}",
    ]) }}>

    <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>

    <span class="sidebar-text">
        {{ $slot }}
    </span>

    @if ($badge)
        <span
            class="nav-badge ml-auto flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">
            {{ $badge }}
        </span>
    @endif

</a>
