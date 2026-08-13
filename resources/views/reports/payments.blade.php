<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Payment Report
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Analyze sales by payment method.
                </p>
            </div>

            <a href="{{ route('reports.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                <i data-lucide="arrow-left" class="h-4 w-4"></i>

                Reports

            </a>

        </div>


        {{-- Filters --}}
        <form method="GET" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 sm:grid-cols-2">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        From
                    </label>

                    <input type="date" name="date_from" value="{{ request('date_from') }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        To
                    </label>

                    <input type="date" name="date_to" value="{{ request('date_to') }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

            </div>

            <div class="mt-4 flex gap-2">

                <button type="submit"
                    class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:scale-[1.01]">

                    Apply Filters

                </button>

                <a href="{{ route('reports.payments') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                    Reset

                </a>

            </div>

        </form>


        {{-- Payment Cards --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            @foreach (['cash', 'upi', 'card', 'bank', 'mixed'] as $method)
                @php
                    $payment = $payments->firstWhere('payment_method', $method);
                @endphp

                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="flex items-center justify-between">

                        <p class="text-sm font-medium capitalize text-slate-500">
                            {{ $method }}
                        </p>

                        @if ($method === 'cash')
                            <i data-lucide="banknote" class="h-5 w-5 text-emerald-500"></i>
                        @elseif($method === 'upi')
                            <i data-lucide="smartphone" class="h-5 w-5 text-blue-500"></i>
                        @elseif($method === 'card')
                            <i data-lucide="credit-card" class="h-5 w-5 text-violet-500"></i>
                        @elseif($method === 'bank')
                            <i data-lucide="landmark" class="h-5 w-5 text-orange-500"></i>
                        @else
                            <i data-lucide="layers" class="h-5 w-5 text-slate-500"></i>
                        @endif

                    </div>

                    <p class="mt-3 text-xl font-bold text-slate-900">
                        ₹{{ number_format($payment?->total ?? 0, 2) }}
                    </p>

                    <p class="mt-1 text-xs text-slate-500">
                        {{ $payment?->count ?? 0 }} transactions
                    </p>

                </div>
            @endforeach

        </div>


        {{-- Detailed Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-900">
                    Payment Breakdown
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Completed sales grouped by payment method.
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">

                        <tr>
                            <th class="px-5 py-4">Payment Method</th>
                            <th class="px-5 py-4">Transactions</th>
                            <th class="px-5 py-4 text-right">Total Amount</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($payments as $payment)
                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4 font-medium capitalize text-slate-900">
                                    {{ $payment->payment_method }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ number_format($payment->count) }}
                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($payment->total, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center text-slate-500">
                                    No payment data found for the selected period.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
