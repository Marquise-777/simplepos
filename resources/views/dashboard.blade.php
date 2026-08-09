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

            <x-stat-card title="Today's Sales" :value="'₹' . number_format($todaySales, 2)" icon="💰" trend="Today's completed sales" />


            <x-stat-card title="Total Sales" value="10" icon="📊" trend="+18% from yesterday" />

            <x-stat-card title="Invoice" value="4" icon="📄" trend="+18% from yesterday" />
            <x-stat-card title="Customer" value="14" icon="👥" trend="+18% from yesterday" />

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

                    <a href="#">
                        <x-button variant="primary" size="md">
                            + New Sale
                        </x-button>
                    </a>

                    <a href="#">
                        <x-button variant="ghost" size="md">
                            Sales History
                        </x-button>
                    </a>

                    <a href="#">
                        <x-button variant="ghost" size="md">
                            Customers
                        </x-button>
                    </a>

                    <a href="#">
                        <x-button variant="ghost" size="md">
                            Reports
                        </x-button>
                    </a>

                </div>

            </div>

            <x-card title="Recent Sales">

                <x-slot:header>
                    <x-button variant="ghost" size="sm">
                        View All
                    </x-button>
                </x-slot:header>

                ...
            </x-card>

        </div>

    </div>

</x-app-layout>
