<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Credit Report
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Track credit sales, collections and outstanding customer dues.
                </p>
            </div>

            <a href="{{ route('reports.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                <i data-lucide="arrow-left" class="mr-2 h-4 w-4"></i>
                Reports
            </a>
        </div>

        {{-- Filters --}}
        <form method="GET" class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        From
                    </label>

                    <input type="date" name="date_from" value="{{ request('date_from', $dateFrom) }}"
                        class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        To
                    </label>

                    <input type="date" name="date_to" value="{{ request('date_to', $dateTo) }}"
                        class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="mb-1.5 block text-sm font-medium text-slate-700">
                        Status
                    </label>

                    <select name="status"
                        class="w-full rounded-xl border border-slate-200 px-3 py-2.5 text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="all" @selected($status === 'all')>
                            All
                        </option>

                        <option value="outstanding" @selected($status === 'outstanding')>
                            Outstanding
                        </option>

                        <option value="overdue" @selected($status === 'overdue')>
                            Overdue
                        </option>

                        <option value="paid" @selected($status === 'paid')>
                            Fully Paid
                        </option>
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-medium text-white transition hover:bg-slate-800">
                        <i data-lucide="filter" class="mr-2 inline h-4 w-4"></i>
                        Apply Filters
                    </button>
                </div>

            </div>

        </form>

        {{-- Summary --}}
        <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-5">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Credit Sales</p>

                <p class="mt-2 text-2xl font-semibold text-slate-900">
                    ₹{{ number_format($summary['credit_amount'], 2) }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Collected</p>

                <p class="mt-2 text-2xl font-semibold text-emerald-600">
                    ₹{{ number_format($summary['paid_amount'], 2) }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Outstanding</p>

                <p class="mt-2 text-2xl font-semibold text-blue-600">
                    ₹{{ number_format($summary['outstanding'], 2) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $summary['active_accounts'] }} active account(s)
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Due Today</p>

                <p class="mt-2 text-2xl font-semibold text-orange-600">
                    ₹{{ number_format($summary['due_today'], 2) }}
                </p>
            </div>

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm text-slate-500">Overdue</p>

                <p class="mt-2 text-2xl font-semibold text-red-600">
                    ₹{{ number_format($summary['overdue'], 2) }}
                </p>

                <p class="mt-1 text-xs text-slate-400">
                    {{ $summary['overdue_accounts'] }} overdue account(s)
                </p>
            </div>

        </div>

        {{-- Credit Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-5 py-4">
                <h2 class="font-semibold text-slate-900">
                    Credit Accounts
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Customer-level outstanding credit and payment status.
                </p>
            </div>

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm">

                    <thead class="bg-slate-50 text-left text-xs font-semibold uppercase tracking-wide text-slate-500">
                        <tr>
                            <th class="px-5 py-3">Customer</th>
                            <th class="px-5 py-3">Invoice</th>
                            <th class="px-5 py-3">Sale Date</th>
                            <th class="px-5 py-3 text-right">Credit</th>
                            <th class="px-5 py-3 text-right">Paid</th>
                            <th class="px-5 py-3 text-right">Outstanding</th>
                            <th class="px-5 py-3 text-right">Overdue</th>
                            <th class="px-5 py-3">Status</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($paginatedRows as $row)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4 font-medium text-slate-800">
                                    {{ $row['customer'] }}
                                </td>

                                <td class="px-5 py-4 text-slate-500">
                                    {{ $row['invoice_no'] }}
                                </td>

                                <td class="px-5 py-4 text-slate-500">
                                    {{ $row['sale_date']?->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4 text-right font-medium text-slate-700">
                                    ₹{{ number_format($row['credit_amount'], 2) }}
                                </td>

                                <td class="px-5 py-4 text-right text-emerald-600">
                                    ₹{{ number_format($row['paid_amount'], 2) }}
                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-blue-600">
                                    ₹{{ number_format($row['outstanding'], 2) }}
                                </td>

                                <td
                                    class="px-5 py-4 text-right font-semibold
                                    {{ $row['overdue'] > 0 ? 'text-red-600' : 'text-slate-400' }}">
                                    ₹{{ number_format($row['overdue'], 2) }}
                                </td>

                                <td class="px-5 py-4">

                                    @if ($row['overdue'] > 0)
                                        <span
                                            class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-medium text-red-600">
                                            Overdue
                                        </span>
                                    @elseif($row['outstanding'] > 0)
                                        <span
                                            class="inline-flex rounded-full bg-blue-50 px-2.5 py-1 text-xs font-medium text-blue-600">
                                            Outstanding
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-medium text-emerald-600">
                                            Paid
                                        </span>
                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="8" class="px-5 py-12 text-center">

                                    <div class="flex flex-col items-center">

                                        <div
                                            class="mb-3 flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-400">
                                            <i data-lucide="receipt-text" class="h-6 w-6"></i>
                                        </div>

                                        <p class="font-medium text-slate-700">
                                            No credit accounts found
                                        </p>

                                        <p class="mt-1 text-sm text-slate-400">
                                            Try changing your filters.
                                        </p>

                                    </div>

                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

            @if ($paginatedRows->hasPages())
                <div class="border-t border-slate-100 px-5 py-4">
                    {{ $paginatedRows->links() }}
                </div>
            @endif

        </div>

    </div>

</x-app-layout>
