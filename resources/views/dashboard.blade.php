<x-app-layout>

    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Welcome back, {{ auth()->user()->name }} 👋
            </p>
        </div>
    </x-slot>

    @if (session('success'))
        <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- Statistics --}}
        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Today's Sales</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    ₹0.00
                </h2>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Invoices</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    0
                </h2>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Customers</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    0
                </h2>
            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6">
                <p class="text-sm text-slate-500">Average Invoice</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">
                    ₹0.00
                </h2>
            </div>

        </div>

        {{-- Main Content --}}
        <div class="grid gap-6 xl:grid-cols-3">

            <div class="xl:col-span-2 rounded-3xl border border-slate-200 bg-white p-6">

                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Recent Sales
                    </h2>

                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                        View All
                    </a>
                </div>

                <div
                    class="mt-8 flex h-72 items-center justify-center rounded-2xl border-2 border-dashed border-slate-200">
                    <p class="text-slate-400">
                        Sales history will appear here.
                    </p>
                </div>

            </div>

            <div class="rounded-3xl border border-slate-200 bg-white p-6">

                <h2 class="text-lg font-semibold text-slate-900">
                    Quick Actions
                </h2>

                <div class="mt-6 space-y-3">

                    <a href="#"
                        class="flex items-center justify-center rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 px-5 py-3 font-semibold text-white transition hover:scale-[1.02]">
                        + New Sale
                    </a>

                    <a href="#"
                        class="flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 font-medium text-slate-700 hover:bg-slate-50">
                        Sales History
                    </a>

                    <a href="#"
                        class="flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 font-medium text-slate-700 hover:bg-slate-50">
                        Customers
                    </a>

                    <a href="#"
                        class="flex items-center justify-center rounded-2xl border border-slate-200 bg-white px-5 py-3 font-medium text-slate-700 hover:bg-slate-50">
                        Reports
                    </a>

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
