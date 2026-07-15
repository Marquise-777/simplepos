<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 w-72 -translate-x-full border-r border-slate-200 bg-white transition-all duration-300 lg:translate-x-0">
    {{-- Logo --}}
    <div class="flex h-20 items-center border-b border-slate-100 px-8">

        <a href="{{ route('dashboard') }}" class="sidebar-brand-link flex items-center gap-3">

            <div
                class="sidebar-brand-logo flex h-11 w-11 items-center justify-center rounded-2xl bg-gradient-to-br from-blue-500 to-cyan-500 text-white shadow-sm">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 logo flex items-center gap-3" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 8h14M5 12h14M5 16h10" />
                </svg>

            </div>

            <div class="sidebar-brand-text">

                <h1 class="text-2xl font-bold text-slate-900">
                    SIMPOS
                </h1>

                <p class="text-xs text-slate-500">
                    Smart POS
                </p>

            </div>

        </a>

    </div>

    {{-- Menu --}}
    <nav class="flex-1 px-5 py-6">

        <p class="sidebar-menu-title mb-3 px-4 text-xs font-semibold uppercase tracking-wider text-slate-400">
            Main Menu
        </p>

        <div class="space-y-2">

            {{-- Dashboard --}}
            <x-sidebar-link :href="route('dashboard')" icon="layout-dashboard" active="dashboard">

                Dashboard

            </x-sidebar-link>

            {{-- New Sale --}}
            {{-- <x-sidebar-link :href="route('sales.create')" icon="plus-circle" active="sales.create" badge="+">

                New Sale

            </x-sidebar-link> --}}

            {{-- Sales --}}
            <x-sidebar-link :href="route('sales.index')" icon="shopping-cart" active="sales.*">

                Sales

            </x-sidebar-link>

            {{-- Customers --}}
            <x-sidebar-link :href="route('customers.index')" icon="users" active="customers.*">

                Customers

            </x-sidebar-link>

            {{-- Reports --}}
            <x-sidebar-link :href="route('reports.index')" icon="bar-chart-2" active="reports.*">

                Reports

            </x-sidebar-link>

            {{-- Settings --}}
            <x-sidebar-link :href="route('settings.index')" icon="settings" active="settings.*">

                Settings

            </x-sidebar-link>

        </div>

    </nav>

    {{-- Plan Card --}}
    <div class="p-5">

        <div class="sidebar-plan-card rounded-3xl border border-blue-100 bg-blue-50 p-5">

            <p class="text-xs uppercase tracking-wide text-slate-500">
                Your Plan
            </p>

            <h3 class="mt-2 text-lg font-semibold text-slate-900">
                Basic Plan
            </h3>

            <span class="mt-2 inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-medium text-green-700">
                Active
            </span>

            <p class="mt-4 text-sm text-slate-500">
                Expires on
            </p>

            <p class="font-semibold text-slate-900">
                30 Jun 2026
            </p>

            {{-- <button
                class="mt-5 w-full rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 py-3 font-medium text-white transition hover:scale-[1.02]">
                Upgrade Plan
            </button> --}}
            <x-button>
                Upgrade Plan
            </x-button>
        </div>

    </div>

    {{-- Footer --}}
    <div class="sidebar-footer border-t border-slate-100 px-6 py-4 text-xs text-slate-400">

        © {{ date('Y') }} SIMPOS

    </div>

</aside>
