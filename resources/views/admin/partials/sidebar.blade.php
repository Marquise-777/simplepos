<aside id="sidebar"
    class="fixed inset-y-0 left-0 z-50 flex w-72 -translate-x-full flex-col border-r border-slate-200 bg-white transition-all duration-300 lg:translate-x-0">

    {{-- Brand --}}
    <div class="flex h-20 items-center border-b border-slate-200 px-6">

        <div class="flex items-center gap-3">

            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white shadow-sm">
                <i data-lucide="layout-dashboard" class="h-5 w-5"></i>
            </div>

            <div class="sidebar-label">
                <h1 class="text-lg font-bold tracking-tight text-slate-900">
                    SIMPOS
                </h1>

                <p class="text-[11px] font-medium uppercase tracking-wider text-slate-400">
                    Super Admin
                </p>
            </div>

        </div>

    </div>


    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-4 py-6">

        {{-- Main --}}
        <p class="sidebar-label mb-3 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
            Overview
        </p>

        <div class="space-y-1">

            {{-- Dashboard --}}
            <a href="{{ route('admin.dashboard') }}"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium transition
                    {{ request()->routeIs('admin.dashboard')
                        ? 'bg-blue-50 text-blue-700'
                        : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                <i data-lucide="layout-dashboard"
                    class="h-5 w-5 shrink-0
                        {{ request()->routeIs('admin.dashboard') ? 'text-blue-600' : 'text-slate-400 group-hover:text-slate-600' }}"></i>

                <span class="sidebar-label">
                    Dashboard
                </span>
            </a>


            {{-- Shops --}}
            <a href="#"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                <i data-lucide="store" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>

                <span class="sidebar-label">
                    Shops
                </span>
            </a>


            {{-- Subscriptions --}}
            <a href="#"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                <i data-lucide="credit-card" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>

                <span class="sidebar-label">
                    Subscriptions
                </span>
            </a>


            {{-- Revenue --}}
            <a href="#"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                <i data-lucide="indian-rupee" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>

                <span class="sidebar-label">
                    Revenue
                </span>
            </a>

        </div>


        {{-- Management --}}
        <p class="sidebar-label mb-3 mt-8 px-3 text-[11px] font-semibold uppercase tracking-wider text-slate-400">
            Management
        </p>

        <div class="space-y-1">

            {{-- Activity Logs --}}
            <a href="#"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                <i data-lucide="activity" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>

                <span class="sidebar-label">
                    Activity Logs
                </span>
            </a>


            {{-- Admin Users --}}
            <a href="#"
                class="group flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-slate-50 hover:text-slate-900">
                <i data-lucide="shield" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-slate-600"></i>

                <span class="sidebar-label">
                    Administrators
                </span>
            </a>

        </div>

    </nav>


    {{-- Bottom --}}
    <div class="border-t border-slate-200 p-4">

        {{-- Admin Profile --}}
        <div class="mb-3 flex items-center gap-3 rounded-xl bg-slate-50 px-3 py-3">

            <div
                class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-blue-100 text-sm font-semibold text-blue-700">
                {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
            </div>

            <div class="sidebar-label min-w-0">
                <p class="truncate text-sm font-semibold text-slate-800">
                    {{ auth('admin')->user()->name }}
                </p>

                <p class="truncate text-xs text-slate-500">
                    Super Administrator
                </p>
            </div>

        </div>


        {{-- Logout --}}
        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf

            <button type="submit"
                class="group flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-600 transition hover:bg-red-50 hover:text-red-600">
                <i data-lucide="log-out" class="h-5 w-5 shrink-0 text-slate-400 group-hover:text-red-500"></i>

                <span class="sidebar-label">
                    Logout
                </span>
            </button>
        </form>

    </div>

</aside>


{{-- Collapsed Sidebar Styling --}}
<style>
    #sidebar.collapsed .sidebar-label {
        display: none;
    }

    #sidebar.collapsed {
        align-items: center;
    }

    #sidebar.collapsed>div:first-child {
        padding-left: 0;
        padding-right: 0;
    }

    #sidebar.collapsed nav {
        width: 100%;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    #sidebar.collapsed nav a {
        justify-content: center;
    }

    #sidebar.collapsed>div:last-child {
        width: 100%;
        padding-left: 0.75rem;
        padding-right: 0.75rem;
    }

    #sidebar.collapsed>div:last-child button {
        justify-content: center;
    }
</style>
