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
        <div x-data="{
            open: false,
            notifications: [{
                    title: 'New sale completed',
                    message: 'Invoice #10025 was successfully created.',
                    time: '2 min ago',
                    unread: true
                },
                {
                    title: 'Subscription Reminder',
                    message: 'Your Pro plan expires in 7 days.',
                    time: '1 hour ago',
                    unread: true
                },
                {
                    title: 'Welcome to SIMPOS',
                    message: 'Your shop setup is complete.',
                    time: 'Yesterday',
                    unread: false
                }
            ],
        
            get unreadCount() {
                return this.notifications.filter(n => n.unread).length;
            },
        
            markAllRead() {
                this.notifications.forEach(n => n.unread = false);
            }
        }" class="relative">

            <!-- Bell -->
            <button @click="open=!open" class="relative rounded-xl p-2 text-slate-600 transition hover:bg-slate-100">

                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 17h5l-1.4-1.4A2 2 0 0118 14.2V11a6 6 0 10-12 0v3.2a2 2 0 01-.6 1.4L4 17h5m6 0a3 3 0 11-6 0m6 0H9" />

                </svg>

                <span x-show="unreadCount > 0" x-text="unreadCount"
                    class="absolute right-1 top-1 flex h-5 w-5 items-center justify-center rounded-full bg-blue-600 text-[10px] font-bold text-white">
                </span>

            </button>

            <!-- Dropdown -->
            <div x-cloak x-show="open" @click.away="open=false" x-transition
                class="absolute right-0 z-50 mt-3 w-96 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">

                <div class="flex items-center justify-between  p-5">

                    <h3 class="font-semibold text-slate-800">
                        Notifications
                    </h3>

                    <button @click="markAllRead()" class="text-sm text-blue-600 hover:text-blue-700">

                        Mark all as read

                    </button>

                </div>

                <div class="max-h-96 overflow-y-auto">

                    <template x-for="item in notifications" :key="item.title">

                        <div class=" border-slate-100 p-4 transition hover:bg-slate-50">

                            <div class="flex items-start gap-3">

                                <div class="mt-2 h-2 w-2 rounded-full"
                                    :class="item.unread ? 'bg-blue-500' : 'bg-transparent'">
                                </div>

                                <div class="flex-1">

                                    <p class="font-medium text-slate-800" x-text="item.title">
                                    </p>

                                    <p class="mt-1 text-sm text-slate-500" x-text="item.message">
                                    </p>

                                    <p class="mt-2 text-xs text-slate-400" x-text="item.time">
                                    </p>

                                </div>

                            </div>

                        </div>

                    </template>

                </div>

                <div class=" p-4 text-center">

                    <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">

                        View All Notifications

                    </a>

                </div>

            </div>

        </div>

        {{-- User --}}
        <div x-data="{ open: false }" class="relative">

            <button @click="open = !open" class="flex items-center gap-3 rounded-2xl p-1 transition hover:bg-slate-100">

                <div class="hidden text-right md:block">

                    <p class="text-sm font-semibold text-slate-900">
                        {{ auth()->user()->shop->name ?? 'My Store' }}
                    </p>

                    <p class="text-xs text-slate-500">
                        {{ ucfirst(auth()->user()->role ?? 'Owner') }}
                    </p>

                </div>

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-full bg-gradient-to-br from-blue-600 to-cyan-500 font-semibold text-white">

                    {{ strtoupper(substr(auth()->user()->name, 0, 2)) }}

                </div>

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="hidden h-5 w-5 text-slate-500 transition duration-200 md:block"
                    :class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                    stroke-width="2">

                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />

                </svg>

            </button>

            <!-- Dropdown -->
            <div x-cloak x-show="open" @click.away="open = false" x-transition
                class="absolute right-0 z-50 mt-3 w-64 overflow-hidden rounded-3xl border border-slate-200 bg-white shadow-xl">

                <div class="border-b border-slate-100 p-5">

                    <p class="font-semibold text-slate-800">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="mt-1 text-sm text-slate-500">
                        {{ auth()->user()->email }}
                    </p>

                </div>

                <div class="p-2">

                    <a href="{{ route('profile.edit') }}"
                        class="flex items-center rounded-2xl px-4 py-3 text-sm text-slate-700 transition hover:bg-slate-100">
                        Profile
                    </a>



                    <form method="POST" action="{{ route('logout') }}" class="mt-1">
                        @csrf

                        <button type="submit"
                            class="flex w-full items-center rounded-2xl px-4 py-3 text-left text-sm font-medium text-red-600 transition hover:bg-red-50">

                            Logout

                        </button>
                    </form>

                </div>

            </div>

        </div>

    </div>

</header>
