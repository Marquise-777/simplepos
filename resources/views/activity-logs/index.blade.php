<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Activity Log
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Track important actions and changes made in your business.
            </p>
        </div>

        {{-- Filters --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <form method="GET" action="{{ route('activity-logs.index') }}" class="flex flex-col gap-3 sm:flex-row">

                {{-- Search --}}
                <div class="relative flex-1">

                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400">
                    </i>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search activity..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </div>

                {{-- Action --}}
                <select name="action"
                    class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm text-slate-700 outline-none focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                    <option value="">
                        All activities
                    </option>

                    @foreach ($actions as $action)
                        <option value="{{ $action }}" @selected(request('action') === $action)>
                            {{ ucwords(str_replace('_', ' ', $action)) }}
                        </option>
                    @endforeach

                </select>

                <button type="submit"
                    class="rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                    Filter
                </button>

                @if (request('search') || request('action'))
                    <a href="{{ route('activity-logs.index') }}"
                        class="inline-flex items-center justify-center rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium text-slate-600 hover:bg-slate-50">
                        Clear
                    </a>
                @endif

            </form>

        </div>

        {{-- Activity List --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-900">
                    Recent Activity
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    A record of actions performed in your shop.
                </p>
            </div>

            @if ($logs->count())

                <div class="divide-y divide-slate-100">

                    @foreach ($logs as $log)
                        <div class="flex gap-4 px-5 py-4 transition hover:bg-slate-50">

                            {{-- Icon --}}
                            <div
                                class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-blue-600">

                                @php
                                    $icon = match ($log->action) {
                                        'sale_created' => 'receipt',
                                        'payment_received' => 'banknote',
                                        'sale_cancelled' => 'circle-x',
                                        'sale_refunded' => 'rotate-ccw',
                                        'credit_created' => 'credit-card',
                                        'installment_due' => 'calendar',
                                        'installment_overdue' => 'triangle-alert',
                                        default => 'activity',
                                    };
                                @endphp

                                <i data-lucide="{{ $icon }}" class="h-5 w-5"></i>

                            </div>

                            {{-- Content --}}
                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                                    <p class="font-medium text-slate-900">
                                        {{ ucwords(str_replace('_', ' ', $log->action)) }}
                                    </p>

                                    <time class="text-xs text-slate-400"
                                        title="{{ $log->created_at->format('d M Y, h:i A') }}">
                                        {{ $log->created_at->diffForHumans() }}
                                    </time>

                                </div>

                                <p class="mt-1 text-sm text-slate-600">
                                    {{ $log->description }}
                                </p>

                                <div class="mt-2 flex flex-wrap items-center gap-x-3 gap-y-1 text-xs text-slate-400">

                                    <span class="inline-flex items-center gap-1">
                                        <i data-lucide="user" class="h-3.5 w-3.5"></i>
                                        {{ $log->user?->name ?? 'Unknown User' }}
                                    </span>

                                    @if ($log->ip_address)
                                        <span>
                                            IP {{ $log->ip_address }}
                                        </span>
                                    @endif

                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                {{-- Pagination --}}
                @if ($logs->hasPages())
                    <div class="border-t border-slate-200 px-5 py-4">
                        {{ $logs->links() }}
                    </div>
                @endif
            @else
                <div class="px-6 py-16 text-center">

                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                        <i data-lucide="activity" class="h-7 w-7 text-slate-400"></i>
                    </div>

                    <h3 class="font-semibold text-slate-900">
                        No activity yet
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Important actions performed in your shop will appear here.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
