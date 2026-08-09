@props(['href' => '#', 'active' => false])

<a
    {{ $attributes->merge([
        'href' => $href,
        'class' =>
            'inline-flex items-center px-3 py-2 text-sm font-medium rounded-md transition ' .
            ($active ? 'text-blue-600 bg-blue-50' : 'text-gray-600 hover:text-gray-900 hover:bg-gray-100'),
    ]) }}>
    {{ $slot }}
</a>
