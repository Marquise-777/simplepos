<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'SIMPOS Setup')</title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>


    {{-- Inter Font --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap" rel="stylesheet">

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    },
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            100: '#dbeafe',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
    <script src="https://unpkg.com/lucide@latest"></script>
</head>

<body class="min-h-screen bg-slate-100 font-sans">

    <!-- Background -->
    <div class="fixed inset-0 -z-10 overflow-hidden">

        <div class="absolute -top-40 -left-40 h-96 w-96 rounded-full bg-blue-200 opacity-30 blur-3xl">
        </div>

        <div class="absolute bottom-0 right-0 h-[500px] w-[500px] rounded-full bg-indigo-200 opacity-30 blur-3xl">
        </div>

    </div>

    <!-- Logo -->
    <header class="pt-8">

        <div class="mx-auto max-w-7xl px-6">

            <a href="/" class="inline-flex items-center gap-2">

                <div
                    class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-600 text-lg font-bold text-white">
                    S
                </div>

                <div>

                    <h1 class="text-lg font-bold text-slate-900">
                        SIMPOS
                    </h1>

                    <p class="-mt-1 text-sm text-slate-500">
                        Setup Wizard
                    </p>

                </div>

            </a>

        </div>

    </header>

    <!-- Page -->
    <main class="mx-auto max-w-7xl px-6 py-10">

        @yield('content')

    </main>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>
