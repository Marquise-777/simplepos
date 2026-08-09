<x-app-layout>
    <div class="space-y-6">
        <x-toast />
        {{-- Header --}}
        <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">
            <div>
                <h1 class="text-3xl font-bold tracking-tight text-slate-900">
                    Customers
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    Manage your customers and their purchase history.
                </p>
            </div>

            <div x-data="{ customerModal: false }">


                <x-button @click="customerModal = true" type="button">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                    </svg>

                    New Customer
                </x-button>


                {{-- Modal goes here --}}
                <!-- Customer Modal -->
                <div x-clock x-show="customerModal" x-transition.opacity x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 p-4">

                    <div @click.away="customerModal = false" x-transition
                        class="w-full max-w-lg rounded-2xl bg-white shadow-2xl">

                        {{-- Header --}}
                        <div class="flex items-center justify-between border-b border-slate-200 px-6 py-4">

                            <div>
                                <h2 class="text-xl font-semibold text-slate-900">
                                    New Customer
                                </h2>

                                <p class="text-sm text-slate-500">
                                    Create a customer for future invoices.
                                </p>
                            </div>

                            <button @click="customerModal = false" class="rounded-lg p-2 hover:bg-slate-100">

                                ✕

                            </button>

                        </div>

                        {{-- Form --}}
                        <form action="{{ route('customers.store') }}" method="POST">

                            @csrf

                            <div class="space-y-5 p-6">

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">
                                        Customer Name
                                    </label>

                                    <input type="text" name="name" required
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none">

                                </div>

                                <div>
                                    <label class="mb-2 block text-sm font-medium text-slate-700">
                                        Phone
                                    </label>

                                    <input type="text" name="phone"
                                        class="w-full rounded-xl border border-slate-200 px-4 py-3 focus:border-blue-500 focus:outline-none">

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

                            </div>

                            {{-- Footer --}}
                            <div class="flex justify-end gap-3 border-t border-slate-200 px-6 py-4">

                                <button type="button" @click="customerModal = false"
                                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-medium hover:bg-slate-50">

                                    Cancel

                                </button>

                                <x-button type="submit">
                                    Save Customer
                                </x-button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>

        {{-- Search --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">
            <div class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between">

                <div class="relative w-full md:max-w-md">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                        viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                    </svg>

                    <form method="GET" class="relative w-full md:max-w-md">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                        </svg>

                        <form method="GET" class="relative w-full md:max-w-md">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="absolute left-4 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-4.35-4.35M11 19a8 8 0 100-16 8 8 0 000 16z" />
                            </svg>

                            <input type="text" name="search" value="{{ request('search') }}"
                                placeholder="Search customers..."
                                class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3 pl-11 pr-4 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">

                        </form>

                    </form>
                </div>

                <span class="text-sm text-slate-500">
                    Total Customers:
                    <span class="font-semibold text-slate-900">
                        {{ $customers->count() }}
                    </span>
                </span>

            </div>
        </div>

        {{-- Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-slate-200 bg-slate-50">
                        <tr>
                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Customer
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Email
                            </th>

                            <th
                                class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Phone
                            </th>

                            <th
                                class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse($customers as $customer)
                            <tr class="transition hover:bg-slate-50">

                                {{-- Customer --}}
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">

                                        <div
                                            class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 font-semibold text-blue-600">
                                            {{ strtoupper(substr($customer->name, 0, 1)) }}
                                        </div>

                                        <div>
                                            <p class="font-medium text-slate-900">
                                                {{ $customer->name }}
                                            </p>

                                            <p class="text-xs text-slate-500">
                                                Customer #{{ $customer->id }}
                                            </p>
                                        </div>

                                    </div>
                                </td>

                                {{-- Email --}}
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $customer->email ?: '—' }}
                                </td>

                                {{-- Phone --}}
                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $customer->phone ?: '—' }}
                                </td>

                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a href="#"
                                            class="rounded-lg border border-slate-200 px-3 py-2 text-sm font-medium text-slate-700 transition hover:bg-slate-100">
                                            Edit
                                        </a>

                                        <form action="" method="POST">
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit" onclick="return confirm('Delete this customer?')"
                                                class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-sm font-medium text-red-600 transition hover:bg-red-100">
                                                Delete
                                            </button>
                                        </form>

                                    </div>

                                </td>

                            </tr>
                        @empty

                            <tr>

                                <td colspan="4" class="px-6 py-20 text-center">

                                    <div class="mx-auto flex max-w-sm flex-col items-center">

                                        <div
                                            class="mb-5 flex h-16 w-16 items-center justify-center rounded-full bg-slate-100">

                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400"
                                                fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 20h5V4H2v16h5m10 0v-2a4 4 0 00-8 0v2m8 0H9m4-10a4 4 0 100-8 4 4 0 000 8z" />
                                            </svg>

                                        </div>

                                        <h3 class="text-lg font-semibold text-slate-900">
                                            No customers found
                                        </h3>

                                        <p class="mt-2 text-sm text-slate-500">
                                            Start by adding your first customer.
                                        </p>

                                        <a href="{{ route('customers.create') }}"
                                            class="mt-6 inline-flex items-center rounded-xl bg-blue-600 px-5 py-2.5 text-sm font-medium text-white transition hover:bg-blue-700">
                                            Add Customer
                                        </a>

                                    </div>

                                </td>

                            </tr>
                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

        {{-- Pagination --}}
        @if (method_exists($customers, 'links'))
            <div class="flex justify-end">
                {{ $customers->links() }}
            </div>
        @endif

    </div>
</x-app-layout>
