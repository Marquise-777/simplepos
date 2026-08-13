<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Credit & EMI
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage customer credit, EMI plans and outstanding payments.
            </p>
        </div>

        {{-- Stats --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <x-stat-card title="Outstanding" value="₹{{ number_format($outstanding, 2) }}" icon="💰" />

            <x-stat-card title="Due Today" value="₹{{ number_format($dueToday, 2) }}" icon="📅" />

            <x-stat-card title="Overdue" value="₹{{ number_format($overdue, 2) }}" icon="⚠️" />

        </div>
        <div class="flex flex-wrap items-center gap-2">

            <a href="{{ route('credit-emi.index') }}"
                class="rounded-xl bg-slate-900 px-4 py-2 text-sm font-medium text-white">
                All Plans
            </a>

            <a href="{{ route('credit-emi.index', ['filter' => 'due']) }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Due Today
            </a>

            <a href="{{ route('credit-emi.index', ['filter' => 'overdue']) }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 hover:bg-slate-50">
                Overdue
            </a>
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <form method="GET" action="{{ route('credit-emi.index') }}" class="relative w-full sm:max-w-sm">

                    @if (request('filter'))
                        <input type="hidden" name="filter" value="{{ request('filter') }}">
                    @endif

                    <i data-lucide="search" class="absolute left-3 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400"></i>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Search customer or phone..."
                        class="w-full rounded-xl border border-slate-200 bg-white py-2.5 pl-10 pr-4 text-sm outline-none transition focus:border-blue-500 focus:ring-2 focus:ring-blue-100">

                </form>

                @if (request('search') || request('filter'))
                    <a href="{{ route('credit-emi.index') }}"
                        class="text-sm font-medium text-slate-500 hover:text-blue-600">
                        Clear filters
                    </a>
                @endif

            </div>
        </div>



        {{-- Payment Plans --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-900">
                    Payment Plans
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Mutual agreements and financer-based EMI plans.
                </p>
            </div>

            @if ($plans->count())

                <div class="overflow-x-auto">

                    <table class="w-full text-left text-sm">

                        <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                            <tr>
                                <th class="px-5 py-3">Customer</th>
                                <th class="px-5 py-3">Invoice</th>
                                <th class="px-5 py-3">Type</th>
                                <th class="px-5 py-3">Total</th>
                                <th class="px-5 py-3">Installment</th>
                                <th class="px-5 py-3">Status</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @foreach ($plans as $plan)
                                @php
                                    $customer = $plan->sale->customer;

                                    $paid = $plan->sale->payments->sum('amount');

                                    $remaining = max(0, (float) $plan->total_payable - (float) $paid);
                                @endphp

                                <tr onclick="window.location='{{ route('credit-emi.show', $plan) }}'"
                                    class="cursor-pointer transition hover:bg-slate-50">

                                    <td class="px-5 py-4">
                                        <p class="font-medium text-slate-900">
                                            {{ $customer?->name ?? 'Walk-in Customer' }}
                                        </p>

                                        @if ($customer?->phone)
                                            <p class="mt-0.5 text-xs text-slate-500">
                                                {{ $customer->phone }}
                                            </p>
                                        @endif
                                    </td>

                                    <td class="px-5 py-4 font-medium text-slate-700">
                                        {{ $plan->sale->invoice_no }}
                                    </td>

                                    <td class="px-5 py-4">

                                        @if ($plan->type === 'financer')
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-purple-50 px-3 py-1 text-xs font-medium text-purple-700">
                                                <i data-lucide="building-2" class="h-3.5 w-3.5"></i>
                                                Financer
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center gap-1.5 rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                                <i data-lucide="handshake" class="h-3.5 w-3.5"></i>
                                                Mutual
                                            </span>
                                        @endif

                                    </td>

                                    <td class="px-5 py-4 font-medium text-slate-900">
                                        ₹{{ number_format($plan->total_payable, 2) }}
                                    </td>

                                    <td class="px-5 py-4 text-slate-600">
                                        ₹{{ number_format($plan->installment_amount, 2) }}
                                    </td>

                                    <td class="px-5 py-4">

                                        @if ($remaining <= 0)
                                            <span
                                                class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                                Paid
                                            </span>
                                        @elseif($plan->status === 'active')
                                            <span
                                                class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                                                ₹{{ number_format($remaining, 2) }} Due
                                            </span>
                                        @else
                                            <span
                                                class="rounded-full bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                                {{ ucfirst($plan->status) }}
                                            </span>
                                        @endif

                                    </td>

                                </tr>
                            @endforeach

                        </tbody>

                    </table>

                </div>
            @else
                <div class="px-6 py-16 text-center">

                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">
                        <i data-lucide="credit-card" class="h-7 w-7 text-slate-400"></i>
                    </div>

                    <h3 class="font-semibold text-slate-900">
                        No credit or EMI plans
                    </h3>

                    <p class="mx-auto mt-1 max-w-md text-sm text-slate-500">
                        Payment plans will appear here when you create them from a sale.
                    </p>

                </div>

            @endif

        </div>

    </div>

</x-app-layout>
