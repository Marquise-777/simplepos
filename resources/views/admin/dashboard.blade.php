@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')

    {{-- Welcome --}}
    <div class="mb-8">
        <h1 class="text-2xl font-bold text-slate-900">
            Dashboard
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Overview of your SIMPOS SaaS platform.
        </p>
    </div>


    {{-- Stats --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total Shops --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Shops
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['total_shops']) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="store" class="h-5 w-5"></i>
                </div>

            </div>

            <p class="mt-4 text-xs text-slate-400">
                Registered businesses
            </p>

        </div>


        {{-- Active Shops --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Shops
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['active_shops']) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-green-600">
                    <i data-lucide="store" class="h-5 w-5"></i>
                </div>

            </div>

            <p class="mt-4 text-xs text-slate-400">
                Currently active
            </p>

        </div>


        {{-- Active Subscriptions --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Subscriptions
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($stats['active_subscriptions']) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-purple-600">
                    <i data-lucide="credit-card" class="h-5 w-5"></i>
                </div>

            </div>

            <p class="mt-4 text-xs text-slate-400">
                Currently active plans
            </p>

        </div>


        {{-- Monthly Revenue --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Monthly Revenue
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        ₹{{ number_format($stats['monthly_revenue'], 2) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-50 text-amber-600">
                    <i data-lucide="indian-rupee" class="h-5 w-5"></i>
                </div>

            </div>

            <p class="mt-4 text-xs text-slate-400">
                Active monthly plans
            </p>

        </div>

    </div>


    {{-- Lower Section --}}
    <div class="mt-6 grid grid-cols-1 gap-6 xl:grid-cols-2">


        {{-- Recent Shops --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Recent Shops
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Latest businesses registered
                    </p>
                </div>

                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    View all
                </a>

            </div>


            <div class="divide-y divide-slate-100">

                @forelse ($recentShops as $shop)
                    <div class="flex items-center justify-between px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div
                                class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-sm font-semibold text-slate-600">
                                {{ strtoupper(substr($shop->name, 0, 1)) }}
                            </div>

                            <div>
                                <p class="text-sm font-semibold text-slate-800">
                                    {{ $shop->name }}
                                </p>

                                <p class="text-xs text-slate-500">
                                    {{ $shop->email ?? 'No email' }}
                                </p>
                            </div>

                        </div>


                        <span
                            class="rounded-full px-2.5 py-1 text-xs font-medium
                            @if ($shop->status === 'active') bg-green-50 text-green-700
                            @elseif ($shop->status === 'suspended')
                                bg-red-50 text-red-700
                            @else
                                bg-slate-100 text-slate-600 @endif">
                            {{ ucfirst($shop->status) }}
                        </span>

                    </div>

                @empty

                    <div class="px-6 py-10 text-center">

                        <i data-lucide="store" class="mx-auto h-8 w-8 text-slate-300"></i>

                        <p class="mt-3 text-sm text-slate-500">
                            No shops registered yet.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>


        {{-- Admin Activity --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Admin Activity
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Recent administrative actions
                    </p>
                </div>

                <a href="#" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                    View all
                </a>

            </div>


            <div class="divide-y divide-slate-100">

                @forelse ($recentActivities as $activity)
                    <div class="px-6 py-4">

                        <div class="flex items-start gap-3">

                            <div
                                class="mt-0.5 flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-50 text-blue-600">
                                <i data-lucide="activity" class="h-4 w-4"></i>
                            </div>

                            <div class="min-w-0 flex-1">

                                <p class="text-sm font-medium text-slate-800">
                                    {{ $activity->action }}
                                </p>

                                @if ($activity->description)
                                    <p class="mt-1 text-xs text-slate-500">
                                        {{ $activity->description }}
                                    </p>
                                @endif

                                <p class="mt-1 text-[11px] text-slate-400">
                                    {{ $activity->created_at->diffForHumans() }}
                                </p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="px-6 py-10 text-center">

                        <i data-lucide="activity" class="mx-auto h-8 w-8 text-slate-300"></i>

                        <p class="mt-3 text-sm text-slate-500">
                            No admin activity yet.
                        </p>

                    </div>
                @endforelse

            </div>

        </div>

    </div>

@endsection
