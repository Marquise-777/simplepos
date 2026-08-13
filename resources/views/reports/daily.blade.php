<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Daily Report
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View sales performance day by day.
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

                    <input type="date" name="date_from" value="{{ $dateFrom }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        To
                    </label>

                    <input type="date" name="date_to" value="{{ $dateTo }}"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

            </div>

            <div class="mt-4 flex gap-2">

                <button type="submit"
                    class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:scale-[1.01]">

                    Apply Filters

                </button>

                <a href="{{ route('reports.daily') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                    Reset

                </a>

            </div>

        </form>


        {{-- Summary --}}
        @php
            $totalSales = $daily->sum('total_sales');
            $totalInvoices = $daily->sum('invoice_count');
            $averageDaily = $daily->count() > 0 ? $totalSales / $daily->count() : 0;
        @endphp

        <div class="grid gap-4 sm:grid-cols-3">

            <x-stat-card title="Total Sales" value="₹{{ number_format($totalSales, 2) }}" icon="💰" />

            <x-stat-card title="Total Invoices" value="{{ number_format($totalInvoices) }}" icon="🧾" />

            <x-stat-card title="Average Daily Sales" value="₹{{ number_format($averageDaily, 2) }}" icon="📊" />

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-900">
                    Daily Sales
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Completed sales grouped by date.
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">

                        <tr>
                            <th class="px-5 py-4">Date</th>
                            <th class="px-5 py-4">Invoices</th>
                            <th class="px-5 py-4 text-right">Total Sales</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($daily as $row)
                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4 font-medium text-slate-900">
                                    {{ \Carbon\Carbon::parse($row->date)->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ number_format($row->invoice_count) }}
                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($row->total_sales, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="3" class="px-5 py-12 text-center text-slate-500">
                                    No sales found for the selected period.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
