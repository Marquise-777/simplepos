@props(['title', 'value', 'icon' => '📊', 'trend' => null])

<div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

    <div class="flex items-start justify-between">

        <div>

            <p class="text-sm font-medium text-slate-500">
                {{ $title }}
            </p>

            <h3 class="mt-2 text-3xl font-bold text-slate-800">
                {{ $value }}
            </h3>

            @if ($trend)
                <p class="mt-3 text-sm font-medium text-green-600">
                    {{ $trend }}
                </p>
            @endif

        </div>

        <div
            class="flex h-14 w-14 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 text-2xl text-white shadow-lg shadow-blue-500/20">
            {{ $icon }}
        </div>

    </div>

</div>
