<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMPOS') }}</title>

    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/app.css') }}" />

</head>

<body class="bg-slate-100 antialiased">

    {{-- Sidebar --}}
    @include('partials.sidebar')

    {{-- Mobile Overlay --}}
    <div id="sidebar-overlay" class="fixed inset-0 z-40 hidden bg-black/40 lg:hidden">
    </div>

    {{-- Main Content --}}
    <div id="main-content" class="min-h-screen lg:ml-72">

        @include('partials.topbar')

        <main class="p-6">

            @isset($header)
                <div class="mb-6">
                    {{ $header }}
                </div>
            @endisset

            {{ $slot }}

        </main>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {

            const sidebar = document.getElementById('sidebar');
            const content = document.getElementById('main-content');
            const overlay = document.getElementById('sidebar-overlay');
            const toggle = document.getElementById('sidebar-toggle');

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

            overlay.addEventListener('click', () => {

                sidebar.classList.add('-translate-x-full');
                overlay.classList.add('hidden');

            });

        });
    </script>
    <script>
        lucide.createIcons();
    </script>
</body>

</html>
