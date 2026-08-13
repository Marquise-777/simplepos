<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Sales Report
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Detailed overview of your sales performance.
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

            <div class="grid gap-4 md:grid-cols-4">

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

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select name="status"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">

                        <option value="all">All Status</option>
                        <option value="completed" @selected(request('status') === 'completed')>
                            Completed
                        </option>
                        <option value="cancelled" @selected(request('status') === 'cancelled')>
                            Cancelled
                        </option>
                        <option value="refunded" @selected(request('status') === 'refunded')>
                            Refunded
                        </option>
                        <option value="draft" @selected(request('status') === 'draft')>
                            Draft
                        </option>

                    </select>
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Search
                    </label>

                    <input type="text" name="search" value="{{ request('search') }}"
                        placeholder="Invoice or customer..."
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                </div>

            </div>

            <div class="mt-4 flex gap-2">

                <button type="submit"
                    class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-5 py-2.5 text-sm font-medium text-white transition hover:scale-[1.01]">

                    Apply Filters

                </button>

                <a href="{{ route('reports.sales') }}"
                    class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-medium text-slate-700 hover:bg-slate-50">

                    Reset

                </a>

            </div>

        </form>


        {{-- Summary --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <x-stat-card title="Total Sales" value="₹{{ number_format($summary['total_sales'], 2) }}" icon="💰" />

            <x-stat-card title="Invoices" value="{{ number_format($summary['invoice_count']) }}" icon="🧾" />

            <x-stat-card title="Average Invoice" value="₹{{ number_format($summary['average_invoice'], 2) }}"
                icon="📊" />

            <x-stat-card title="Cancelled" value="{{ number_format($summary['cancelled']) }}" icon="❌" />

            <x-stat-card title="Refunded" value="{{ number_format($summary['refunded']) }}" icon="↩️" />

        </div>


        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="border-b border-slate-200 bg-slate-50 text-xs uppercase text-slate-500">

                        <tr>
                            <th class="px-5 py-4">Invoice</th>
                            <th class="px-5 py-4">Date</th>
                            <th class="px-5 py-4">Customer</th>
                            <th class="px-5 py-4">Cashier</th>
                            <th class="px-5 py-4">Payment</th>
                            <th class="px-5 py-4">Status</th>
                            <th class="px-5 py-4 text-right">Amount</th>
                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($sales as $sale)
                            <tr class="hover:bg-slate-50">

                                <td class="whitespace-nowrap px-5 py-4 font-medium text-slate-900">
                                    {{ $sale->invoice_no }}
                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-slate-500">
                                    {{ \Carbon\Carbon::parse($sale->invoice_date)->format('d M Y, h:i A') }}
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                                </td>

                                <td class="px-5 py-4 text-slate-700">
                                    {{ $sale->user?->name ?? '—' }}
                                </td>

                                <td class="px-5 py-4 capitalize text-slate-700">
                                    {{ $sale->payment_method }}
                                </td>

                                <td class="px-5 py-4">

                                    <span
                                        class="rounded-full px-2.5 py-1 text-xs font-medium
                                        @if ($sale->status === 'completed') bg-emerald-50 text-emerald-700
                                        @elseif($sale->status === 'cancelled')
                                            bg-red-50 text-red-700
                                        @elseif($sale->status === 'refunded')
                                            bg-orange-50 text-orange-700
                                        @else
                                            bg-slate-100 text-slate-600 @endif">

                                        {{ ucfirst($sale->status) }}

                                    </span>

                                </td>

                                <td class="whitespace-nowrap px-5 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($sale->grand_total, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                    No sales found for the selected filters.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($sales->hasPages())
                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $sales->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>
