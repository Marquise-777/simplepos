<header
    class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/90 px-6 backdrop-blur">

    {{-- Left --}}
    <div class="flex items-center gap-4">

        {{-- Sidebar Toggle --}}
        <button type="button" id="sidebar-toggle"
            class="flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
            <i data-lucide="menu" class="h-5 w-5"></i>
        </button>


        {{-- Page Context --}}
        <div class="hidden sm:block">
            <p class="text-xs font-medium uppercase tracking-wider text-slate-400">
                SIMPOS SaaS
            </p>

            <h2 class="text-lg font-semibold text-slate-800">
                @yield('title', 'Admin Dashboard')
            </h2>
        </div>

    </div>


    {{-- Right --}}
    <div class="flex items-center gap-3">

        {{-- System Status --}}
        <div
            class="hidden items-center gap-2 rounded-full border border-green-200 bg-green-50 px-3 py-1.5 text-xs font-medium text-green-700 md:flex">
            <span class="h-2 w-2 rounded-full bg-green-500"></span>
            System Online
        </div>


        {{-- Notifications --}}
        <button type="button"
            class="relative flex h-10 w-10 items-center justify-center rounded-xl text-slate-500 transition hover:bg-slate-100 hover:text-slate-700">
            <i data-lucide="bell" class="h-5 w-5"></i>

            {{-- Notification indicator --}}
            <span class="absolute right-2.5 top-2.5 h-2 w-2 rounded-full bg-blue-600"></span>
        </button>


        {{-- Divider --}}
        <div class="hidden h-8 w-px bg-slate-200 sm:block"></div>


        {{-- Admin --}}
        <div class="flex items-center gap-3">

            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-slate-800">
                    {{ auth('admin')->user()->name }}
                </p>

                <p class="text-xs text-slate-500">
                    Super Admin
                </p>
            </div>


            {{-- Avatar --}}
            <div
                class="flex h-10 w-10 items-center justify-center rounded-full bg-blue-100 text-sm font-bold text-blue-700">
                {{ strtoupper(substr(auth('admin')->user()->name, 0, 1)) }}
            </div>

        </div>

    </div>

</header>
