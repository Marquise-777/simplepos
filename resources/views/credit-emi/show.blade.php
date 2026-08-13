<x-app-layout>

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <a href="{{ route('credit-emi.index') }}"
                    class="mb-2 inline-flex items-center gap-1 text-sm text-slate-500 hover:text-blue-600">
                    <i data-lucide="arrow-left" class="h-4 w-4"></i>
                    Back to Credit & EMI
                </a>

                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $paymentPlan->sale->customer?->name ?? 'Walk-in Customer' }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Invoice {{ $paymentPlan->sale->invoice_no }}
                </p>
            </div>

            <span class="inline-flex w-fit rounded-full bg-amber-50 px-3 py-1.5 text-sm font-medium text-amber-700">
                {{ ucfirst($paymentPlan->type) }}
            </span>

        </div>

        {{-- Summary --}}
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

            <x-stat-card title="Total Payable" value="₹{{ number_format($paymentPlan->total_payable, 2) }}"
                icon="💰" />

            <x-stat-card title="Paid" value="₹{{ number_format($paid, 2) }}" icon="✓" />

            <x-stat-card title="Outstanding" value="₹{{ number_format($outstanding, 2) }}" icon="⚠️" />

        </div>

        {{-- Plan Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <h2 class="font-semibold text-slate-900">
                Payment Plan
            </h2>

            <div class="mt-5 grid grid-cols-2 gap-5 md:grid-cols-4">

                <div>
                    <p class="text-xs text-slate-500">Plan Type</p>
                    <p class="mt-1 font-medium text-slate-900">
                        {{ ucfirst($paymentPlan->type) }}
                    </p>
                </div>

                @if ($paymentPlan->financer_name)
                    <div>
                        <p class="text-xs text-slate-500">Financer</p>
                        <p class="mt-1 font-medium text-slate-900">
                            {{ $paymentPlan->financer_name }}
                        </p>
                    </div>
                @endif

                <div>
                    <p class="text-xs text-slate-500">Installment</p>
                    <p class="mt-1 font-medium text-slate-900">
                        ₹{{ number_format($paymentPlan->installment_amount, 2) }}
                    </p>
                </div>

                <div>
                    <p class="text-xs text-slate-500">Frequency</p>
                    <p class="mt-1 font-medium text-slate-900">
                        {{ ucfirst($paymentPlan->frequency) }}
                    </p>
                </div>

            </div>

        </div>

        {{-- Installments --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-5 py-4">
                <h2 class="font-semibold text-slate-900">
                    Installments
                </h2>
            </div>

            <div class="overflow-x-auto">

                <table class="w-full text-left text-sm">

                    <thead class="bg-slate-50 text-xs uppercase text-slate-500">
                        <tr>
                            <th class="px-5 py-3">#</th>
                            <th class="px-5 py-3">Due Date</th>
                            <th class="px-5 py-3">Amount</th>
                            <th class="px-5 py-3">Paid</th>
                            <th class="px-5 py-3">Remaining</th>
                            <th class="px-5 py-3">Status</th>
                            <th class="px-5 py-3">Action</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @foreach ($paymentPlan->installments as $index => $installment)
                            @php
                                $remaining = max(0, (float) $installment->amount - (float) $installment->paid_amount);
                            @endphp

                            <tr>

                                <td class="px-5 py-4 text-slate-500">
                                    {{ $index + 1 }}
                                </td>

                                <td class="px-5 py-4 font-medium text-slate-900">
                                    {{ $installment->due_date->format('d M Y') }}
                                </td>

                                <td class="px-5 py-4">
                                    ₹{{ number_format($installment->amount, 2) }}
                                </td>

                                <td class="px-5 py-4 text-green-600">
                                    ₹{{ number_format($installment->paid_amount, 2) }}
                                </td>

                                <td class="px-5 py-4 font-medium">
                                    ₹{{ number_format($remaining, 2) }}
                                </td>

                                <td class="px-5 py-4">

                                    @if ($installment->status === 'paid')
                                        <span
                                            class="rounded-full bg-green-50 px-3 py-1 text-xs font-medium text-green-700">
                                            Paid
                                        </span>
                                    @elseif($installment->status === 'overdue')
                                        <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-medium text-red-700">
                                            Overdue
                                        </span>
                                    @elseif($installment->status === 'partial')
                                        <span
                                            class="rounded-full bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                            Partial
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-amber-50 px-3 py-1 text-xs font-medium text-amber-700">
                                            Pending
                                        </span>
                                    @endif

                                </td>
                                <td class="px-5 py-4">

                                    @if ($remaining > 0)
                                        <form method="POST" action="{{ route('credit-emi.payment', $paymentPlan) }}"
                                            class="flex items-center gap-2">

                                            @csrf

                                            <input type="hidden" name="installment_id" value="{{ $installment->id }}">

                                            <input type="number" name="amount" step="0.01" min="0.01"
                                                max="{{ $remaining }}" value="{{ $remaining }}"
                                                class="w-28 rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-100">

                                            <select name="payment_method"
                                                class="rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-blue-500 focus:outline-none">
                                                <option value="cash">Cash</option>
                                                <option value="upi">UPI</option>
                                                <option value="bank">Bank</option>
                                                <option value="card">Card</option>
                                                <option value="mixed">Mixed</option>
                                            </select>

                                            <button type="submit"
                                                class="rounded-lg bg-blue-600 px-3 py-2 text-sm font-medium text-white transition hover:bg-blue-700">
                                                Pay
                                            </button>

                                        </form>
                                    @else
                                        <span class="text-xs font-medium text-green-600">
                                            Completed
                                        </span>
                                    @endif

                                </td>

                            </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
