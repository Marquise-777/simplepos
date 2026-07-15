<x-app-layout>

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">Sales</h1>
            <p class="mt-1 text-sm text-slate-500">
                Create a sale and manage your recent invoices.
            </p>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">New Sale</h2>
                        <p class="mt-1 text-sm text-slate-500">
                            Record a sale in just a few clicks.
                        </p>
                    </div>

                    <span class="rounded-full bg-blue-50 px-4 py-2 text-xs font-semibold text-blue-700">
                        Draft
                    </span>

                </div>
            </div>

            <div class="space-y-6 p-6" x-data="{
                rows: [{ item: '', qty: 1, rate: 0 }],
                addRow() {
                    this.rows.push({ item: '', qty: 1, rate: 0 });
                },
                removeRow(index) {
                    if (this.rows.length > 1) {
                        this.rows.splice(index, 1);
                    }
                },
                formatCurrency(value) {
                    return new Intl.NumberFormat('en-IN', {
                        style: 'currency',
                        currency: 'INR',
                        maximumFractionDigits: 2
                    }).format(value || 0);
                }
            }">

                <div class="grid gap-4 lg:grid-cols-4">

                    <div>
                        <x-input label="Customer" placeholder="Walk-in Customer" />
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Payment
                        </label>

                        <select
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                            <option>Cash</option>
                            <option>UPI</option>
                            <option>Card</option>
                            <option>Bank</option>
                        </select>
                    </div>

                    <div>
                        <x-input label="Invoice No." value="INV-2026-000001" disabled />
                    </div>

                    <div>
                        <x-input label="Invoice Date" type="date" />
                    </div>

                </div>

                <div class="overflow-x-auto rounded-2xl border border-slate-200">

                    <table class="min-w-[720px] w-full">

                        <thead class="bg-slate-50">
                            <tr class="text-left text-sm font-semibold text-slate-500">
                                <th class="px-5 py-4">Item</th>
                                <th class="w-28 px-5 py-4">Qty</th>
                                <th class="w-40 px-5 py-4">Rate</th>
                                <th class="w-44 px-5 py-4">Amount</th>
                                <th class="w-16"></th>
                            </tr>
                        </thead>

                        <tbody>

                            <template x-for="(row, index) in rows" :key="index">
                                <tr class="border-t border-slate-100">

                                    <td class="p-5">
                                        <input x-model="row.item" placeholder="Enter item name"
                                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 placeholder:text-slate-400 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    </td>

                                    <td class="p-5">
                                        <input x-model.number="row.qty" type="number" min="1" value="1"
                                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    </td>

                                    <td class="p-5">
                                        <input x-model.number="row.rate" type="number" min="0" step="0.01"
                                            placeholder="0.00"
                                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                    </td>

                                    <td class="px-5">
                                        <span class="text-xl font-bold text-slate-900"
                                            x-text="formatCurrency(row.qty * row.rate)"></span>
                                    </td>

                                    <td class="text-center">
                                        <button type="button" @click="removeRow(index)"
                                            class="rounded-xl p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-600"
                                            :class="{ 'opacity-40 cursor-not-allowed': rows.length === 1 }"
                                            :disabled="rows.length === 1">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                    d="M3 6h18M8 6V4h8v2m-9 0v14a2 2 0 002 2h6a2 2 0 002-2V6" />

                                            </svg>

                                        </button>
                                    </td>

                                </tr>
                            </template>

                        </tbody>

                    </table>

                </div>

                <button type="button" @click="addRow()"
                    class="inline-flex items-center gap-2 rounded-xl border border-dashed border-slate-300 px-5 py-3 text-sm font-medium text-slate-600 transition hover:border-blue-400 hover:bg-blue-50 hover:text-blue-600">
                    <i data-lucide="plus" class="h-4 w-4"></i>
                    Add Item
                </button>

                <div
                    class="flex flex-col gap-6 border-t border-slate-100 pt-6 lg:flex-row lg:items-end lg:justify-between">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Notes
                        </label>

                        <textarea rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 lg:w-[430px]"
                            placeholder="Additional notes..."></textarea>
                    </div>

                    <div class="space-y-5">

                        <div class="rounded-3xl bg-gradient-to-r from-blue-50 to-cyan-50 px-8 py-6 text-right">
                            <p class="text-sm font-medium uppercase tracking-wide text-slate-500">
                                Grand Total
                            </p>

                            <h2 class="mt-2 text-5xl font-extrabold text-blue-600">
                                ₹0.00
                            </h2>
                        </div>

                        <div class="flex justify-end gap-2">
                            <x-button variant="secondary">
                                Clear
                            </x-button>

                            <x-button>
                                Save Sale
                            </x-button>
                        </div>

                    </div>

                </div>

            </div>

        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm">

            {{-- Header --}}
            <div
                class="flex flex-col gap-4 border-b border-slate-100 px-6 py-5 lg:flex-row lg:items-center lg:justify-between">

                <div class="flex items-center gap-3">

                    <h2 class="text-lg font-semibold text-slate-900">
                        Recent Sales
                    </h2>

                    <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        Today
                    </span>

                </div>


                <div class="flex flex-col gap-3 md:flex-row">

                    <x-input class="sm:w-72" placeholder="Search invoice, customer..." />


                    <select
                        class="rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                        <option>All Status</option>
                        <option>Completed</option>
                        <option>Draft</option>
                        <option>Cancelled</option>
                        <option>Refunded</option>

                    </select>

                </div>
                <div class="flex items-center gap-2">

                    <x-button variant="secondary">
                        Export
                    </x-button>

                    <x-button variant="danger">
                        Delete
                    </x-button>

                </div>

            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-sm font-semibold text-slate-500">

                            <th class="w-12 px-4 py-4">
                                <input type="checkbox">
                            </th>
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Items</th>
                            <th class="px-6 py-4">Payment</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @for ($i = 1; $i <= 5; $i++)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-4 py-5">
                                    <input type="checkbox">
                                </td>
                                <td class="px-6 py-5">

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            INV-2026-000{{ $i }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            #{{ str_pad($i, 4, '0', STR_PAD_LEFT) }}
                                        </p>

                                    </div>

                                </td>

                                <td class="px-6 py-5">

                                    <div>

                                        <p class="font-medium text-slate-900">
                                            Walk-in Customer
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            Cashier
                                        </p>

                                    </div>

                                </td>

                                <td class="px-6 py-5 text-slate-600">
                                    {{ now()->format('d M Y') }}
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        3 Items
                                    </span>
                                </td>

                                <td class="px-6 py-5">
                                    <span
                                        class="rounded-full bg-blue-100 px-3 py-1 text-xs font-semibold text-blue-700">
                                        Cash
                                    </span>
                                </td>

                                <td class="px-6 py-5 text-right">

                                    <span class="text-lg font-bold text-slate-900">
                                        ₹350.00
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <span
                                        class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Completed
                                    </span>

                                </td>

                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <button
                                            class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">

                                            <i data-lucide="eye" class="h-4 w-4"></i>

                                        </button>

                                        {{-- Print --}}
                                        <button
                                            class="rounded-xl p-2 text-blue-500 transition hover:bg-blue-50 hover:text-blue-700">

                                            <i data-lucide="printer" class="h-4 w-4"></i>

                                        </button>

                                        {{-- More --}}
                                        <button
                                            class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">

                                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>

                                        </button>

                                    </div>

                                </td>

                            </tr>
                        @endfor

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</x-app-layout>
