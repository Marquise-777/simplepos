<header class="sticky top-0 z-30 flex h-18 items-center justify-between border-b border-slate-200 bg-white px-4 md:px-6">

    {{-- Left --}}
    <div class="flex items-center gap-4">

        <button id="sidebar-toggle" class="rounded-xl p-2 text-slate-600 transition hover:bg-slate-100">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                stroke-width="2">

                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />

            </svg>

        </button>



    </div>

    {{-- Right --}}
    <div class="flex items-center gap-3 md:gap-5">

        {{-- Notification --}}
        <button class="relative rounded-xl p-2 text-slate-600 transition hover:bg-slate-100">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">

                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />

            </svg>

            <span
                class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white">
                3
            </span>

        </button>

        {{-- User --}}
        <button class="flex items-center gap-3 rounded-2xl p-1 transition hover:bg-slate-100">

            <div class="hidden text-right md:block">

                <p class="text-sm font-semibold text-slate-900">
                    {{ auth()->user()->shop->name ?? 'My Store' }}
                </p>

                <p class="text-xs text-slate-500">
                    {{ ucfirst(auth()->user()->role ?? 'Owner') }}
                </p>

            </div>

            <div
                class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-blue-500 to-cyan-500 font-semibold text-white">

                {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}

            </div>

            <svg xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5 text-slate-500 md:block" fill="none"
                viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">

                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

            </svg>

        </button>

    </div>

</header>
