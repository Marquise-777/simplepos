<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SIMPOS') }}</title>

    <!-- Font -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>

    <!-- Alpine -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="min-h-screen bg-slate-100 font-[Figtree]">

    <div class="grid min-h-screen lg:grid-cols-2">

        <!-- Left Branding -->
        <div class="relative hidden overflow-hidden bg-gradient-to-br from-blue-700 via-blue-600 to-cyan-500 lg:flex">

            <div class="absolute inset-0 bg-black/5"></div>

            <!-- Decorative Blobs -->
            <div class="absolute -left-24 -top-24 h-80 w-80 rounded-full bg-white/10 blur-3xl">
            </div>

            <div class="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-cyan-300/20 blur-3xl">
            </div>

            <div class="relative z-10 flex h-full flex-col justify-center px-20 text-white">

                <div
                    class="mb-8 flex h-20 w-20 items-center justify-center rounded-3xl bg-white/15 text-3xl font-bold backdrop-blur">

                    S

                </div>

                <h1 class="text-5xl font-bold leading-tight">
                    SIMPOS
                </h1>

                <p class="mt-4 max-w-md text-lg text-blue-100">
                    The modern POS system built for small businesses.
                    Fast invoices, beautiful dashboard and simple workflow.
                </p>

                <div class="mt-10 space-y-4 text-blue-100">

                    <div>✓ Fast Billing</div>

                    <div>✓ Cloud Based</div>

                    <div>✓ Multi-Shop Ready</div>

                    <div>✓ Beautiful Reports</div>

                </div>

            </div>

        </div>

        <!-- Right Form -->
        <div class="flex items-center justify-center p-6 lg:p-12">

            <div class="w-full max-w-md">

                <!-- Mobile Logo -->
                <div class="mb-8 text-center lg:hidden">

                    <div
                        class="mx-auto flex h-20 w-20 items-center justify-center rounded-3xl bg-gradient-to-br from-blue-600 to-cyan-500 text-3xl font-bold text-white">

                        S

                    </div>

                    <h1 class="mt-5 text-3xl font-bold text-slate-800">
                        SIMPOS
                    </h1>

                    <p class="mt-2 text-slate-500">
                        Welcome back.
                    </p>

                </div>

                <x-card>

                    {{ $slot }}

                </x-card>

                <p class="mt-8 text-center text-sm text-slate-500">
                    © {{ now()->year }} SIMPOS. All rights reserved.
                </p>

            </div>

        </div>

    </div>

</body>

</html>
