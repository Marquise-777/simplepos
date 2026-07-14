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
            <a href="{{ route('dashboard') }}"
                class="flex items-center gap-3 rounded-2xl bg-blue-50 px-4 py-3 font-medium transition hover:bg-blue-100">

                <i data-lucide="layout-dashboard" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>

                <p class="sidebar-text" style="color: rgb(54, 85, 105)">Dashboard</p>

            </a>

            {{-- New Sale --}}
            <a href="#"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                <i data-lucide="plus-circle" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>

                <p class="sidebar-text" style="color: rgb(54, 85, 105)">New Sale</p>

                <span
                    class="nav-badge ml-auto flex h-6 w-6 items-center justify-center rounded-full bg-blue-600 text-xs font-semibold text-white">
                    +
                </span>

            </a>

            {{-- Sales --}}
            <a href="#"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                <i data-lucide="shopping-cart" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>
                <p class="sidebar-text" style="color: rgb(54, 85, 105)">Sales</p>

            </a>

            {{-- Customers --}}
            <a href="#"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                <i data-lucide="users" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>
                <p class="sidebar-text" style="color: rgb(54, 85, 105)">Customers</p>

            </a>

            {{-- Reports --}}
            <a href="#"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                <i data-lucide="bar-chart-2" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>
                <p class="sidebar-text" style="color: rgb(54, 85, 105)">Reports</p>

            </a>

            {{-- Settings --}}
            <a href="#"
                class="flex items-center gap-3 rounded-2xl px-4 py-3 text-slate-600 transition hover:bg-slate-100 hover:text-slate-900">

                <i data-lucide="settings" class="h-5 w-5" style="color: rgb(54, 85, 105)"></i>
                <p class="sidebar-text" style="color: rgb(54, 85, 105)">Settings</p>

            </a>

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

            <button
                class="mt-5 w-full rounded-2xl bg-gradient-to-r from-blue-600 to-cyan-500 py-3 font-medium text-white transition hover:scale-[1.02]">
                Upgrade Plan
            </button>

        </div>

    </div>

    {{-- Footer --}}
    <div class="sidebar-footer border-t border-slate-100 px-6 py-4 text-xs text-slate-400">

        © {{ date('Y') }} SIMPOS

    </div>

</aside>
