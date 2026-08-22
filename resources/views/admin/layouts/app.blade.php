<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        @yield('title', 'Admin') — {{ config('app.name', 'SIMPOS') }}
    </title>

    <style>
        [x-cloak] {
            display: none !important;
        }

        html {
            scroll-behavior: smooth;
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body class="bg-slate-100 antialiased">

    {{-- Success Toast --}}
    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 3000)"
            class="fixed right-6 top-6 z-[100] flex items-center gap-3 rounded-2xl border border-green-200 bg-white px-5 py-4 text-sm font-medium text-green-700 shadow-xl">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-green-100">
                <i data-lucide="check" class="h-4 w-4"></i>
            </div>

            <span>{{ session('success') }}</span>

            <button type="button" @click="show = false"
                class="ml-2 rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>
    @endif


    {{-- Error Toast --}}
    @if (session('error'))
        <div x-data="{ show: true }" x-show="show" x-transition x-init="setTimeout(() => show = false, 4000)"
            class="fixed right-6 top-6 z-[100] flex items-center gap-3 rounded-2xl border border-red-200 bg-white px-5 py-4 text-sm font-medium text-red-700 shadow-xl">
            <div class="flex h-8 w-8 items-center justify-center rounded-full bg-red-100">
                <i data-lucide="alert-circle" class="h-4 w-4"></i>
            </div>

            <span>{{ session('error') }}</span>

            <button type="button" @click="show = false"
                class="ml-2 rounded-lg p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                <i data-lucide="x" class="h-4 w-4"></i>
            </button>
        </div>
    @endif


    {{-- Sidebar --}}
    @include('admin.partials.sidebar')


    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden"></div>


    {{-- Main Content --}}
    <div id="main-content" class="min-h-screen lg:ml-72">

        {{-- Topbar --}}
        @include('admin.partials.topbar')


        <main class="p-6">

            {{-- Optional Page Header --}}
            @hasSection('header')
                <div class="mb-6">
                    @yield('header')
                </div>
            @endif


            {{-- Page Content --}}
            @yield('content')

        </main>

    </div>


    {{-- Sidebar Behaviour --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle = document.getElementById('sidebar-toggle');

            if (!sidebar || !content || !toggle || !overlay) {
                return;
            }

            let collapsed = false;

            toggle.addEventListener('click', () => {

                // Mobile
                if (window.innerWidth < 1024) {

                    sidebar.classList.toggle('-translate-x-full');
                    overlay.classList.toggle('hidden');

                    return;
                }

                // Desktop
                collapsed = !collapsed;

                sidebar.classList.toggle('collapsed');

                if (collapsed) {

                    sidebar.classList.replace('w-72', 'w-20');
                    content.classList.replace('lg:ml-72', 'lg:ml-20');

                } else {

                    sidebar.classList.replace('w-20', 'w-72');
                    content.classList.replace('lg:ml-20', 'lg:ml-72');

                }

            });


            // Mobile overlay
            overlay.addEventListener('click', () => {

                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');

            });

        });
    </script>


    {{-- Icons --}}
    <script>
        lucide.createIcons();
    </script>


    {{-- Alpine --}}
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>

</body>

</html>
