<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>
                <h1 class="text-2xl font-semibold text-slate-900">
                    Sale Details
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Invoice {{ $sale->invoice_no }}
                </p>
            </div>

            <div class="flex gap-2">

                <a href="{{ route('sales.index') }}"
                    class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back
                </a>

                <a href="{{ route('sales.print', $sale) }}" target="_blank"
                    class="inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:scale-[1.02]">
                    <i data-lucide="printer" class="h-4 w-4"></i>
                    Print Invoice
                </a>

            </div>

        </div>


        {{-- Sale Information --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Invoice Information
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Details of this sale.
                        </p>
                    </div>

                    @php
                        $statusColors = [
                            'completed' => 'bg-green-100 text-green-700',
                            'draft' => 'bg-yellow-100 text-yellow-700',
                            'cancelled' => 'bg-red-100 text-red-700',
                            'refunded' => 'bg-purple-100 text-purple-700',
                        ];
                    @endphp

                    <span
                        class="rounded-full px-4 py-2 text-xs font-semibold
                        {{ $statusColors[$sale->status] ?? 'bg-slate-100 text-slate-700' }}">
                        {{ ucfirst($sale->status) }}
                    </span>

                </div>

            </div>


            <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-4">

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Invoice No.
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $sale->invoice_no }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Customer
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                    </p>

                    @if ($sale->customer?->phone)
                        <p class="mt-1 text-xs text-slate-500">
                            {{ $sale->customer->phone }}
                        </p>
                    @endif
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Invoice Date
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ $sale->invoice_date?->format('d M Y') ?? '-' }}
                    </p>
                </div>

                <div>
                    <p class="text-xs font-medium uppercase tracking-wide text-slate-400">
                        Payment
                    </p>

                    <p class="mt-1 font-semibold text-slate-900">
                        {{ ucfirst($sale->payment_method) }}
                    </p>
                </div>

            </div>

        </div>


        {{-- Items --}}
        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">

                <h2 class="text-lg font-semibold text-slate-900">
                    Items
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Items included in this invoice.
                </p>

            </div>


            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-sm font-semibold text-slate-500">

                            <th class="px-6 py-4">
                                #
                            </th>

                            <th class="px-6 py-4">
                                Item
                            </th>

                            <th class="px-6 py-4 text-right">
                                Qty
                            </th>

                            <th class="px-6 py-4 text-right">
                                Rate
                            </th>

                            <th class="px-6 py-4 text-right">
                                Amount
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($sale->items as $index => $item)
                            <tr>

                                <td class="px-6 py-4 text-sm text-slate-400">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-6 py-4">

                                    <p class="font-medium text-slate-900">
                                        {{ $item->item_name }}
                                    </p>

                                </td>

                                <td class="px-6 py-4 text-right text-slate-600">
                                    {{ rtrim(rtrim(number_format($item->quantity, 2), '0'), '.') }}
                                </td>

                                <td class="px-6 py-4 text-right text-slate-600">
                                    ₹{{ number_format($item->rate, 2) }}
                                </td>

                                <td class="px-6 py-4 text-right font-semibold text-slate-900">
                                    ₹{{ number_format($item->amount, 2) }}
                                </td>

                            </tr>

                        @empty

                            <tr>
                                <td colspan="5" class="px-6 py-10 text-center text-sm text-slate-500">
                                    No items found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Summary --}}
        <div class="flex justify-end">

            <div class="w-full rounded-3xl border border-slate-200 bg-white p-6 shadow-sm sm:w-[420px]">

                <div class="space-y-4">

                    <div class="flex items-center justify-between text-sm">
                        <span class="text-slate-500">
                            Subtotal
                        </span>

                        <span class="font-medium text-slate-900">
                            ₹{{ number_format($sale->subtotal, 2) }}
                        </span>
                    </div>

                    @if ($sale->discount > 0)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">
                                Discount
                                @if ($sale->discount_type === 'percentage')
                                    ({{ rtrim(rtrim(number_format($sale->discount_value, 2), '0'), '.') }}%)
                                @endif
                            </span>

                            <span class="font-medium text-red-600">
                                -₹{{ number_format($sale->discount, 2) }}
                            </span>
                        </div>
                    @endif

                    @if ($sale->tax > 0)
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">
                                Tax
                                @if ($sale->tax_rate !== null)
                                    ({{ rtrim(rtrim(number_format($sale->tax_rate, 2), '0'), '.') }}%)
                                @endif
                            </span>

                            <span class="font-medium text-slate-900">
                                ₹{{ number_format($sale->tax, 2) }}
                            </span>
                        </div>
                    @endif

                    <div class="border-t border-slate-100 pt-4">

                        <div class="flex items-center justify-between">

                            <span class="text-base font-semibold text-slate-700">
                                Grand Total
                            </span>

                            <span class="text-2xl font-extrabold text-blue-600">
                                ₹{{ number_format($sale->grand_total, 2) }}
                            </span>

                        </div>

                    </div>

                    {{-- Payment Summary --}}
                    @php
                        $paidAmount = $sale->payments->sum('amount');
                        $outstanding = max($sale->grand_total - $paidAmount, 0);
                    @endphp

                    <div class="border-t border-slate-100 pt-4 space-y-3">

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">
                                Amount Paid
                            </span>

                            <span class="font-semibold text-green-600">
                                ₹{{ number_format($paidAmount, 2) }}
                            </span>
                        </div>

                        <div class="flex items-center justify-between">

                            <span class="text-sm font-semibold text-slate-700">
                                Outstanding
                            </span>

                            <span class="text-lg font-bold {{ $outstanding > 0 ? 'text-red-600' : 'text-green-600' }}">
                                ₹{{ number_format($outstanding, 2) }}
                            </span>

                        </div>

                        <div class="pt-1 text-right">

                            @if ($outstanding <= 0)
                                <span
                                    class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Paid in Full
                                </span>
                            @elseif ($paidAmount > 0)
                                <span
                                    class="inline-flex rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                    Partially Paid
                                </span>
                            @else
                                <span
                                    class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                    Unpaid
                                </span>
                            @endif

                        </div>

                    </div>

                </div>

            </div>

        </div>


        {{-- Notes --}}
        @if ($sale->notes)
            <div class="rounded-3xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-sm font-semibold text-slate-900">
                    Notes
                </h2>

                <p class="mt-2 whitespace-pre-line text-sm text-slate-500">
                    {{ $sale->notes }}
                </p>

            </div>
        @endif

    </div>

</x-app-layout>
