@props([
    'title' => null,
    'subtitle' => null,
])

<div
    {{ $attributes->merge([
        'class' => '
                    rounded-3xl
                    border
                    border-slate-200
                    bg-white
                    p-6
                    shadow-sm
                ',
    ]) }}>

    @if ($title || isset($header))

        <div class="mb-6 flex items-center justify-between">

            <div>

                @if ($title)
                    <h2 class="text-lg font-semibold text-slate-800">
                        {{ $title }}
                    </h2>
                @endif

                @if ($subtitle)
                    <p class="mt-1 text-sm text-slate-500">
                        {{ $subtitle }}
                    </p>
                @endif

            </div>

            @isset($header)
                {{ $header }}
            @endisset

        </div>

    @endif

    {{ $slot }}

</div>
