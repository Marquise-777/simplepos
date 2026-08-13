<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Monthly Report
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Compare your sales performance month by month.
                </p>
            </div>

            <a href="{{ route('reports.index') }}"
                class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                <i data-lucide="arrow-left" class="h-4 w-4"></i>

                Reports

            </a>

        </div>


        {{-- Year Filter --}}
        <form method="GET" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-end">

                <div class="w-full sm:max-w-xs">

                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Year
                    </label>

                    <select name="year"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">

                        @for ($y = now()->year; $y >= now()->year - 5; $y--)
                            <option value="{{ $y }}" @selected((int) $year === $y)>
                                {{ $y }}
                            </option>
                        @endfor

                    </select>

                </div>

                <button type="submit"
                    class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:scale-[1.01]">

                    Apply

                </button>

                <a href="{{ route('reports.monthly') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                    Current Year

                </a>

            </div>

        </form>


        {{-- Summary --}}
        @php
            $totalSales = $monthly->sum('total_sales');
            $totalInvoices = $monthly->sum('invoice_count');

            $averageMonthly = $monthly->count() > 0 ? $totalSales / $monthly->count() : 0;

            $bestMonth = $monthly->sortByDesc('total_sales')->first();
        @endphp

        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

            <x-stat-card title="Total Sales" value="₹{{ number_format($totalSales, 2) }}" icon="💰" />

            <x-stat-card title="Total Invoices" value="{{ number_format($totalInvoices) }}" icon="🧾" />

            <x-stat-card title="Average Monthly Sales" value="₹{{ number_format($averageMonthly, 2) }}"
                icon="📊" />

            <x-stat-card title="Best Month"
                value="{{ $bestMonth ? '₹' . number_format($bestMonth->total_sales, 2) : '₹0.00' }}" icon="🏆" />

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">

                <h2 class="font-semibold text-slate-900">
                    Monthly Sales — {{ $year }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Completed sales grouped by month.
                </p>

            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">

                        <tr>
                            <th class="px-5 py-4">Month</th>
                            <th class="px-5 py-4">Invoices</th>
                            <th class="px-5 py-4">Average Invoice</th>
                            <th class="px-5 py-4 text-right">Total Sales</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($monthly as $row)
                            @php
                                $averageInvoice = $row->invoice_count > 0 ? $row->total_sales / $row->invoice_count : 0;
                            @endphp

                            <tr class="hover:bg-slate-50">

                                <td class="px-5 py-4 font-medium text-slate-900">
                                    {{ \Carbon\Carbon::create()->month($row->month)->format('F') }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    {{ number_format($row->invoice_count) }}
                                </td>

                                <td class="px-5 py-4 text-slate-600">
                                    ₹{{ number_format($averageInvoice, 2) }}
                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($row->total_sales, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="4" class="px-5 py-12 text-center text-slate-500">
                                    No sales found for {{ $year }}.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
