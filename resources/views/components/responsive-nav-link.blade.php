@props(['href' => '#', 'active' => false])

<a href="{{ $href }}"
    {{ $attributes->merge([
        'class' =>
            'block px-4 py-2 text-base font-medium rounded-md ' .
            ($active ? 'bg-blue-50 text-blue-700' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900'),
    ]) }}>
    {{ $slot }}
</a>
