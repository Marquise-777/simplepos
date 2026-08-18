<x-app-layout>

    <div class="space-y-6">

        {{-- <div>
            <h1 class="text-2xl font-bold text-slate-900">Sales</h1>
            <p class="mt-1 text-sm text-slate-500">
                Create a sale and manage your recent invoices.
            </p>
        </div> --}}

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm" x-data="customerSelector()">
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

            <form method="POST" action="{{ route('sales.store') }}">

                @csrf

                <div class="space-y-6 p-6" x-data="{
                    rows: [{ item: '', qty: 1, rate: 0 }],
                
                    discountType: 'fixed',
                    discountValue: 0,
                    taxRate: 0,
                
                    amountPaid: 0,
                
                    paymentMethod: 'cash',
                
                    get balanceDue() {
                        return Math.max(this.grandTotal - (parseFloat(this.amountPaid) || 0), 0);
                    },
                
                    get paymentStatus() {
                        if (this.amountPaid <= 0) return 'credit';
                        if (this.amountPaid < this.grandTotal) return 'partial';
                        return 'paid';
                    },
                
                    get subtotal() {
                        return this.rows.reduce((total, row) => {
                            return total + ((parseFloat(row.qty) || 0) * (parseFloat(row.rate) || 0));
                        }, 0);
                    },
                
                    get discountAmount() {
                        const value = parseFloat(this.discountValue) || 0;
                
                        if (this.discountType === 'percentage') {
                            return this.subtotal * (value / 100);
                        }
                
                        return value;
                    },
                
                    get taxableAmount() {
                        return Math.max(this.subtotal - this.discountAmount, 0);
                    },
                
                    get taxAmount() {
                        return this.taxableAmount * ((parseFloat(this.taxRate) || 0) / 100);
                    },
                
                    get grandTotal() {
                        return this.taxableAmount + this.taxAmount;
                    },
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

                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Customer
                            </label>

                            <div class="flex gap-2">

                                <div class="relative flex-1">

                                    <select name="customer_id" x-model="selectedCustomer"
                                        class="w-full appearance-none rounded-2xl border border-slate-200 bg-white px-4 py-3 pr-10 shadow-sm transition focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">

                                        <option value="">Walk-in Customer</option>

                                        @foreach ($customers as $customer)
                                            <option value="{{ $customer->id }}">
                                                {{ $customer->name }}
                                                @if ($customer->phone)
                                                    — {{ $customer->phone }}
                                                @endif
                                            </option>
                                        @endforeach

                                    </select>

                                    <i data-lucide="chevron-down"
                                        class="pointer-events-none absolute right-4 top-1/2 h-4 w-4 -translate-y-1/2 text-slate-400">
                                    </i>

                                </div>

                                <button type="button" @click="openModal()"
                                    class="flex h-[50px] w-[50px] shrink-0 items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 via-blue-500 to-cyan-500 text-white shadow-sm transition hover:bg-blue-700 hover:shadow-md"
                                    title="Add Customer">

                                    <i data-lucide="plus" class="h-5 w-5"></i>

                                </button>

                            </div>

                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Payment Method
                            </label>

                            <select name="payment_method" x-model="paymentMethod"
                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 shadow-sm focus:border-blue-500 focus:ring-4 focus:ring-blue-100">

                                <option value="cash">Cash</option>
                                <option value="upi">UPI</option>
                                <option value="card">Card</option>
                                <option value="bank">Bank</option>
                                <option value="mixed">Mixed</option>

                            </select>
                        </div>

                        <div>
                            <x-input label="Invoice No." value="INV-2026-000001" disabled />
                        </div>

                        <div>
                            <x-input label="Invoice Date" name="invoice_date" type="date"
                                value="{{ now()->format('Y-m-d') }}" />
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
                                            <input x-model="row.item" :name="`items[${index}][item_name]`"
                                                placeholder="Enter item name"
                                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 placeholder:text-slate-400 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                        </td>

                                        <td class="p-5">
                                            <input x-model.number="row.qty" :name="`items[${index}][quantity]`"
                                                type="number" min="1" step="0.01"
                                                class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-slate-700 shadow-sm transition focus:border-blue-500 focus:ring-4 focus:ring-blue-100">
                                        </td>

                                        <td class="p-5">
                                            <input x-model.number="row.rate" :name="`items[${index}][rate]`"
                                                type="number" min="0" step="0.01" placeholder="0.00"
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
                        class="flex flex-col gap-6 border-t border-slate-100 pt-6 lg:flex-row lg:items-center lg:justify-between">


                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Notes
                            </label>

                            <textarea name="notes" rows="4" class="w-full rounded-2xl border border-slate-200 px-4 py-3 lg:w-[430px]"
                                placeholder="Additional notes..."></textarea>
                        </div>
                        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                            <!-- Payment box -->
                            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                <label class="mb-2 block text-sm font-medium text-slate-700">Amount Paid</label>

                                <div class="flex items-center gap-2">
                                    <span class="text-sm text-slate-500">₹</span>
                                    <input type="number" name="amount_paid" x-model.number="amountPaid"
                                        @input="if (amountPaid > grandTotal) amountPaid = grandTotal" min="0"
                                        :max="grandTotal" step="0.01"
                                        class="w-32 rounded-xl border border-slate-200 px-3 py-2 text-right text-sm font-medium focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                        placeholder="0.00">
                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-3">
                                    <div class="flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Balance Due</span>
                                        <span class="text-lg font-bold"
                                            :class="balanceDue > 0 ? 'text-red-600' : 'text-green-600'"
                                            x-text="formatCurrency(balanceDue)"></span>
                                    </div>

                                    <div class="mt-3 flex items-center justify-between">
                                        <span class="text-sm text-slate-500">Payment Status</span>
                                        <span class="rounded-full px-3 py-1 text-xs font-semibold"
                                            :class="{
                                                'bg-green-100 text-green-700': paymentStatus === 'paid',
                                                'bg-yellow-100 text-yellow-700': paymentStatus === 'partial',
                                                'bg-red-100 text-red-700': paymentStatus === 'credit'
                                            }"
                                            x-text="paymentStatus.charAt(0).toUpperCase() + paymentStatus.slice(1)">
                                        </span>
                                    </div>

                                    <div x-show="balanceDue > 0" x-transition
                                        class="mt-3 rounded-2xl border border-amber-200 bg-amber-50 p-3">
                                        <div class="flex items-start gap-3">
                                            <i data-lucide="clock-3"
                                                class="mt-0.5 h-5 w-5 shrink-0 text-amber-600"></i>
                                            <div>
                                                <p class="text-sm font-semibold text-amber-800">Outstanding Payment</p>
                                                <p class="mt-1 text-sm text-amber-700"><span
                                                        x-text="formatCurrency(balanceDue)"></span> will remain due
                                                    from the customer.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Summary box -->
                            <div class="rounded-2xl border border-slate-200 bg-white p-4">
                                <div class="flex items-center justify-between text-sm">
                                    <span class="text-slate-500">Subtotal</span>
                                    <span class="font-medium text-slate-900" x-text="formatCurrency(subtotal)"></span>
                                </div>

                                <div class="mt-3">
                                    <label class="mb-2 block text-sm font-medium text-slate-700">Discount</label>
                                    <div class="flex items-center gap-2">
                                        <select name="discount_type" x-model="discountType"
                                            class="rounded-xl border border-slate-200 px-3 py-2 text-sm">
                                            <option value="fixed">₹ Fixed</option>
                                            <option value="percentage">% Percentage</option>
                                        </select>

                                        <input type="number" name="discount_value" x-model.number="discountValue"
                                            min="0" step="0.01"
                                            class="w-28 rounded-xl border border-slate-200 px-3 py-2 text-sm"
                                            placeholder="0">
                                    </div>

                                    <div class="mt-2 flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Discount</span>
                                        <span class="font-medium text-red-600">-<span
                                                x-text="formatCurrency(discountAmount)"></span></span>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="flex items-center justify-between gap-4">
                                        <label class="text-sm font-medium text-slate-700">Tax</label>
                                        <div class="flex items-center gap-2">
                                            <input type="number" name="tax_rate" x-model.number="taxRate"
                                                min="0" step="0.01"
                                                class="w-20 rounded-xl border border-slate-200 px-3 py-2 text-sm"
                                                placeholder="0">
                                            <span class="text-sm text-slate-500">%</span>
                                        </div>
                                    </div>

                                    <div class="mt-2 flex items-center justify-between text-sm">
                                        <span class="text-slate-500">Tax</span>
                                        <span class="font-medium text-slate-900"
                                            x-text="formatCurrency(taxAmount)"></span>
                                    </div>
                                </div>

                                <div class="mt-4 border-t border-slate-100 pt-4">
                                    <div class="flex items-center justify-between">
                                        <span class="text-base font-semibold text-slate-700">Grand Total</span>
                                        <span class="text-2xl font-extrabold text-blue-600"
                                            x-text="formatCurrency(grandTotal)"></span>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="space-y-5">

                            <div class="flex gap-2">

                                <x-button type="button" variant="secondary" @click="window.location.reload()">
                                    Clear
                                </x-button>

                                <x-button type="submit" variant="secondary" name="status" value="draft">
                                    Save Draft
                                </x-button>

                                <x-button type="submit" name="status" value="completed">
                                    Complete Sale
                                </x-button>

                            </div>

                        </div>

                    </div>

                </div>
            </form>

            <div x-show="modalOpen" x-cloak x-transition.opacity
                class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 px-4">

                <div @click.outside="closeModal()" x-transition
                    class="w-full max-w-lg rounded-3xl bg-white shadow-2xl">

                    <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                        <div>
                            <h3 class="text-lg font-semibold text-slate-900">
                                Add Customer
                            </h3>

                            <p class="mt-1 text-sm text-slate-500">
                                Create a customer without leaving the sale.
                            </p>
                        </div>

                        <button type="button" @click="closeModal()"
                            class="rounded-xl p-2 text-slate-400 hover:bg-slate-100 hover:text-slate-700">

                            <i data-lucide="x" class="h-5 w-5"></i>

                        </button>

                    </div>

                    <form method="POST" action="{{ route('customers.store') }}" class="space-y-5 p-6">

                        @csrf

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Name
                            </label>

                            <input type="text" name="name" required
                                class="w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                placeholder="Customer name">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Phone
                            </label>

                            <input type="text" name="phone"
                                class="w-full rounded-2xl border border-slate-200 px-4 py-3 shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100"
                                placeholder="Phone number">
                        </div>
                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Email
                            </label>

                            <input type="email" name="email"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none">

                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Address
                            </label>

                            <textarea name="address" rows="3"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none"></textarea>

                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">
                                Notes
                            </label>

                            <textarea name="notes" rows="2"
                                class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none"></textarea>

                        </div>

                        <div class="flex justify-end gap-2 pt-2">

                            <button type="button" @click="closeModal()"
                                class="rounded-xl border border-slate-200 px-5 py-3 text-sm font-medium text-slate-600 hover:bg-slate-50">
                                Cancel
                            </button>

                            <button type="submit"
                                class="rounded-xl bg-blue-600 px-5 py-3 text-sm font-semibold text-white hover:bg-blue-700">
                                Save Customer
                            </button>

                        </div>

                    </form>

                </div>

            </div>
        </div>

        <div class="rounded-3xl border border-slate-200 bg-white shadow-sm" x-data="salesTable({{ json_encode($sales->pluck('id')->all()) }})">

            {{-- Header --}}
            <div class="border-b border-slate-100 px-6 py-5">
                <div class="flex flex-col gap-4 xl:flex-row xl:items-center xl:justify-between">

                    <div class="flex items-center gap-3 shrink-0">
                        <h2 class="text-lg font-semibold text-slate-900">
                            Recent Sales
                        </h2>

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            Today
                        </span>
                    </div>

                    {{-- Filters --}}
                    <form method="GET" action="{{ route('sales.index') }}"
                        class="flex flex-col gap-2 sm:flex-row sm:flex-wrap">

                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search invoice, customer..."
                            class="w-full rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100 sm:w-64">

                        <select name="status"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">
                            <option value="all" @selected(request('status') === null || request('status') === 'all')>All Status</option>
                            <option value="completed" @selected(request('status') === 'completed')>Completed</option>
                            <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                            <option value="cancelled" @selected(request('status') === 'cancelled')>Cancelled</option>
                            <option value="refunded" @selected(request('status') === 'refunded')>Refunded</option>
                        </select>

                        <input type="date" name="date_from" value="{{ request('date_from') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <input type="date" name="date_to" value="{{ request('date_to') }}"
                            class="rounded-2xl border border-slate-200 bg-white px-4 py-3 text-sm shadow-sm focus:border-blue-500 focus:outline-none focus:ring-4 focus:ring-blue-100">

                        <button type="submit"
                            class="rounded-2xl bg-slate-700 px-5 py-3 text-sm font-semibold text-white hover:bg-slate-800">
                            Filter
                        </button>
                    </form>

                    {{-- Actions --}}
                    <div class="flex items-center gap-2 shrink-0">
                        <x-button variant="secondary">
                            Export
                        </x-button>

                        <form method="POST" action="{{ route('sales.bulk-delete') }}"
                            onsubmit="return confirm('Delete selected sales? This cannot be undone.');"
                            class="inline-block">
                            @csrf
                            @method('DELETE')

                            <template x-for="id in selected" :key="id">
                                <input type="hidden" name="sale_ids[]" :value="id">
                            </template>

                            <button type="submit" :disabled="selected.length === 0"
                                class="inline-flex h-[44px] items-center justify-center rounded-2xl px-5 py-2.5 text-sm font-semibold transition
           bg-gradient-to-r from-red-600 to-rose-500 text-white
           hover:scale-[1.02]
           disabled:cursor-not-allowed disabled:opacity-40 disabled:hover:scale-100">

                                Delete

                                <span x-show="selected.length > 0" class="ml-1">
                                    (<span x-text="selected.length"></span>)
                                </span>

                            </button>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-sm font-semibold text-slate-500">

                            <th class="w-12 px-4 py-4">
                                <input type="checkbox" @change="toggleAll($event)" :checked="allVisibleSelected"
                                    class="rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            </th>
                            <th class="px-6 py-4">Invoice</th>
                            <th class="px-6 py-4">Customer</th>
                            <th class="px-6 py-4">Date</th>
                            <th class="px-6 py-4">Items</th>
                            <th class="px-6 py-4">P Type</th>
                            <th class="px-6 py-4">P Status</th>
                            <th class="px-6 py-4 text-right">Total</th>
                            <th class="px-6 py-4">Status</th>
                            <th class="px-6 py-4 text-center">Actions</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse ($sales as $sale)
                            <tr class="transition hover:bg-slate-50">

                                <td class="px-4 py-5">
                                    <input type="checkbox" value="{{ $sale->id }}"
                                        class="sale-checkbox rounded border-slate-300 text-blue-600 focus:ring-blue-500"
                                        @change="toggle({{ $sale->id }})"
                                        :checked="selected.includes(String({{ $sale->id }}))">
                                </td>

                                {{-- Invoice --}}
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $sale->invoice_no }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            #{{ $sale->id }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Customer --}}
                                <td class="px-6 py-5">
                                    <div>
                                        <p class="font-medium text-slate-900">
                                            {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                                        </p>

                                        <p class="text-xs text-slate-500">
                                            {{ $sale->user?->name ?? '-' }}
                                        </p>
                                    </div>
                                </td>

                                {{-- Date --}}
                                <td class="px-6 py-5 text-slate-600">
                                    {{ $sale->invoice_date?->format('d M Y') }}
                                </td>

                                {{-- Items --}}
                                <td class="px-6 py-5">
                                    <span
                                        class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-700">
                                        {{ $sale->saleItems->count() }} Items
                                    </span>
                                </td>

                                {{-- Payment --}}
                                <td class="px-6 py-5">
                                    @php
                                        $paymentColors = [
                                            'cash' => 'bg-green-100 text-green-700',
                                            'upi' => 'bg-purple-100 text-purple-700',
                                            'card' => 'bg-blue-100 text-blue-700',
                                            'bank' => 'bg-yellow-100 text-yellow-700',
                                            'mixed' => 'bg-slate-100 text-slate-700',
                                        ];
                                    @endphp

                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold {{ $paymentColors[$sale->payment_method] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($sale->payment_method) }}
                                    </span>
                                </td>
                                {{-- Payment Status --}}
                                <td class="px-6 py-5">
                                    @php
                                        $paidAmount = $sale->payments->sum('amount');
                                        $outstanding = max($sale->grand_total - $paidAmount, 0);
                                    @endphp

                                    @if ($outstanding <= 0)
                                        <span
                                            class="rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            Paid
                                        </span>
                                    @elseif ($paidAmount > 0)
                                        <span
                                            class="rounded-full bg-yellow-100 px-3 py-1 text-xs font-semibold text-yellow-700">
                                            Partial
                                        </span>
                                    @else
                                        <span
                                            class="rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Unpaid
                                        </span>
                                    @endif
                                </td>

                                {{-- Total --}}
                                <td class="px-6 py-5 text-right">
                                    @php
                                        $paidAmount = $sale->payments->sum('amount');
                                        $outstanding = max($sale->grand_total - $paidAmount, 0);
                                    @endphp

                                    <span class="text-lg font-bold text-slate-900">
                                        ₹{{ number_format($sale->grand_total, 2) }}
                                    </span>

                                    @if ($outstanding > 0)
                                        <p class="mt-1 text-xs font-medium text-red-600">
                                            ₹{{ number_format($outstanding, 2) }} due
                                        </p>
                                    @else
                                        <p class="mt-1 text-xs font-medium text-green-600">
                                            Paid in full
                                        </p>
                                    @endif
                                </td>

                                {{-- Status --}}
                                <td class="px-6 py-5">
                                    @php
                                        $statusColors = [
                                            'completed' => 'bg-green-100 text-green-700',
                                            'draft' => 'bg-yellow-100 text-yellow-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                            'refunded' => 'bg-purple-100 text-purple-700',
                                        ];
                                    @endphp

                                    <span
                                        class="rounded-full px-3 py-1 text-xs font-semibold {{ $statusColors[$sale->status] ?? 'bg-slate-100 text-slate-700' }}">
                                        {{ ucfirst($sale->status) }}
                                    </span>
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-5">

                                    <div class="flex items-center justify-center gap-2">

                                        {{-- View --}}
                                        <a href="{{ route('sales.show', $sale) }}"
                                            class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                                            title="View Sale">

                                            <i data-lucide="eye" class="h-4 w-4"></i>

                                        </a>


                                        {{-- Print --}}
                                        <a href="{{ route('sales.print', $sale) }}" target="_blank"
                                            class="rounded-xl p-2 text-blue-500 transition hover:bg-blue-50 hover:text-blue-700"
                                            title="Print Invoice">

                                            <i data-lucide="printer" class="h-4 w-4"></i>

                                        </a>


                                        {{-- More --}}
                                        <a href="{{ route('sales.show', $sale) }}"
                                            class="rounded-xl p-2 text-slate-500 transition hover:bg-slate-100 hover:text-slate-700"
                                            title="More">

                                            <i data-lucide="more-horizontal" class="h-4 w-4"></i>

                                        </a>

                                    </div>

                                </td>

                            </tr>
                        @empty

                            <tr>
                                <td colspan="10" class="px-6 py-12 text-center text-slate-500">
                                    No sales found.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                </table>
                <div class=" border-slate-200 bg-white px-6 py-4">
                    {{ $sales->links() }}
                </div>

            </div>

        </div>

    </div>
    <script>
        function customerSelector() {
            return {
                modalOpen: false,

                selectedCustomer: '{{ request('customer_id', '') }}',

                openModal() {
                    this.modalOpen = true;
                },

                closeModal() {
                    this.modalOpen = false;
                }
            }
        }

        function salesTable(visibleIds = []) {
            return {
                selected: [],
                visibleIds: visibleIds,

                get allVisibleSelected() {
                    if (!this.visibleIds.length) {
                        return false;
                    }

                    return this.visibleIds.every(id => this.selected.includes(String(id)));
                },

                toggleAll(event) {
                    const checked = event.target.checked;

                    if (checked) {
                        const ids = this.visibleIds.map(String);
                        this.selected = [...new Set([...this.selected, ...ids])];
                        return;
                    }

                    this.selected = this.selected.filter(id => !this.visibleIds.map(String).includes(id));
                },

                toggle(id) {
                    const value = String(id);

                    if (this.selected.includes(value)) {
                        this.selected = this.selected.filter(item => item !== value);
                        return;
                    }

                    this.selected.push(value);
                }
            }
        }
    </script>

</x-app-layout>
