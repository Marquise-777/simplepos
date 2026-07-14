@extends('layouts.setup')

@section('title', 'Setup Complete')

@section('content')

    <div class="min-h-screen bg-slate-100 py-12 px-6">

        <div class="mx-auto max-w-6xl">

            <div class="rounded-3xl bg-white shadow-xl overflow-hidden">

                <!-- Header -->
                <div class="px-10 py-12 text-center">

                    <div
                        class="relative overflow-hidden rounded-[32px]
           border border-white/30
           bg-gradient-to-br
           from-white/55
           via-blue-50/40
           to-white/30
           backdrop-blur-3xl
           shadow-[0_20px_80px_rgba(37,99,235,0.12)]">

                        <!-- Glow -->
                        <div
                            class="absolute -top-20 -right-20 h-60 w-60 rounded-full
               bg-blue-400/20 blur-3xl">
                        </div>

                        <div
                            class="absolute -bottom-16 -left-16 h-56 w-56 rounded-full
               bg-cyan-300/20 blur-3xl">
                        </div>

                        <div class="relative px-12 py-14 text-center">

                            <div
                                class="mx-auto flex h-24 w-24 items-center justify-center
                   rounded-full
                   bg-white/40
                   border border-white/60
                   backdrop-blur-xl
                   shadow-xl">

                                <i data-lucide="party-popper" class="h-12 w-12 text-blue-600"></i>

                            </div>

                            <h1 class="mt-8 text-5xl font-bold text-slate-800">
                                Congratulations!
                            </h1>

                            <p class="mt-4 text-lg text-slate-600">
                                Your SIMPOS workspace has been successfully configured.
                            </p>

                        </div>

                    </div>

                    <!-- Body -->
                    <div class="p-10">

                        <div class="mb-8 text-center">



                            <p class="mt-3 text-slate-500">
                                Everything has been configured successfully. You can now
                                create invoices, manage sales and customize your business
                                further from the dashboard.
                            </p>

                        </div>

                        <!-- Summary -->

                        <div class="mt-10 grid gap-5">

                            <!-- Business -->
                            <div
                                class="group flex items-center rounded-3xl border border-white/40
               bg-white/40 backdrop-blur-xl
               px-6 py-5
               shadow-lg transition-all duration-300
               hover:-translate-y-1 hover:shadow-2xl">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl
                   bg-gradient-to-br from-green-400 to-emerald-500
                   text-white shadow-lg">

                                    <i data-lucide="badge-check" class="h-7 w-7"></i>

                                </div>

                                <div class="ml-5 flex-1">

                                    <h3 class="text-lg font-semibold text-slate-800">
                                        Business Information
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Your business profile has been configured successfully.
                                    </p>

                                </div>

                                <i data-lucide="chevron-right"
                                    class="h-5 w-5 text-slate-300 transition group-hover:text-blue-500">
                                </i>

                            </div>

                            <!-- Invoice -->
                            <div
                                class="group flex items-center rounded-3xl border border-white/40
               bg-white/40 backdrop-blur-xl
               px-6 py-5
               shadow-lg transition-all duration-300
               hover:-translate-y-1 hover:shadow-2xl">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl
                   bg-gradient-to-br from-blue-500 to-indigo-600
                   text-white shadow-lg">

                                    <i data-lucide="receipt" class="h-7 w-7"></i>

                                </div>

                                <div class="ml-5 flex-1">

                                    <h3 class="text-lg font-semibold text-slate-800">
                                        Invoice Settings
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Invoice template and printing preferences are ready.
                                    </p>

                                </div>

                                <i data-lucide="chevron-right"
                                    class="h-5 w-5 text-slate-300 transition group-hover:text-blue-500">
                                </i>

                            </div>

                            <!-- Workspace -->
                            <div
                                class="group flex items-center rounded-3xl border border-white/40
               bg-white/40 backdrop-blur-xl
               px-6 py-5
               shadow-lg transition-all duration-300
               hover:-translate-y-1 hover:shadow-2xl">

                                <div
                                    class="flex h-14 w-14 items-center justify-center rounded-2xl
                   bg-gradient-to-br from-cyan-500 to-blue-600
                   text-white shadow-lg">

                                    <i data-lucide="rocket" class="h-7 w-7"></i>

                                </div>

                                <div class="ml-5 flex-1">

                                    <h3 class="text-lg font-semibold text-slate-800">
                                        Workspace Ready
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Your SIMPOS workspace is fully configured and ready to use.
                                    </p>

                                </div>

                                <i data-lucide="chevron-right"
                                    class="h-5 w-5 text-slate-300 transition group-hover:text-blue-500">
                                </i>

                            </div>

                        </div>

                        <!-- Action -->

                        <div class="mt-10 text-center">

                            <form method="POST" action="{{ route('setup.finish') }}">
                                @csrf

                                <button type="submit"
                                    class="group inline-flex items-center gap-3
           rounded-full
           bg-gradient-to-r
           from-blue-500
           to-indigo-600
           px-9 py-4
           font-semibold text-white
           shadow-lg
           transition-all duration-300
           hover:shadow-blue-300/40
           hover:-translate-y-0.5">

                                    <span>Go to Dashboard</span>

                                    <i data-lucide="arrow-right"
                                        class="h-5 w-5 transition-transform group-hover:translate-x-1">
                                    </i>

                                </button>
                            </form>

                        </div>

                    </div>

                </div>

            </div>

        </div>

    @endsection
