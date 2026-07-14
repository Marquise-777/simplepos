@extends('layouts.setup')

@section('content')
    <div class="min-h-screen bg-slate-100 py-12 px-6">

        <div class="mx-auto max-w-5xl">

            <!-- Header -->
            <div class="mb-5 text-center">
                <!-- Progress -->
                <div class="mb-10 max-w-3xl mx-auto">

                    <!-- Labels -->
                    <div class="grid grid-cols-3 mb-4">
                        <div class="text-center text-xs font-bold uppercase tracking-wider text-blue-600">
                            Business
                        </div>

                        <div class="text-center text-xs font-bold uppercase tracking-wider text-slate-400">
                            Invoice
                        </div>

                        <div class="text-center text-xs font-bold uppercase tracking-wider text-slate-400">
                            Complete
                        </div>
                    </div>

                    <!-- Progress -->
                    <div class="relative flex items-center justify-between">

                        <!-- Background line -->
                        <div class="absolute left-0 right-0 top-1/2 -translate-y-1/2 h-1 bg-slate-300"></div>

                        <!-- Active line -->
                        <div class="absolute left-0 top-1/2 -translate-y-1/2 h-1 bg-blue-600 w-1/2"></div>

                        <!-- Step 1 -->
                        <div
                            class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white shadow">
                            <i data-lucide="check" class="h-5 w-5"></i>
                        </div>

                        <!-- Step 2 -->
                        <div
                            class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-300 bg-white text-slate-400">
                            2
                        </div>

                        <!-- Step 3 -->
                        <div
                            class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-300 bg-white text-slate-400">
                            3
                        </div>

                    </div>

                </div>

                <h1 class="mt-5 text-4xl font-bold text-slate-900">
                    Welcome to SIMPOS 👋
                </h1>

                <p class="mt-3 text-lg text-slate-500">
                    Let's configure your business before you start creating invoices.
                </p>
            </div>

            <!-- Card -->
            <div class="rounded-3xl bg-white shadow-xl">

                <form method="POST" action="{{ route('setup.business.store') }}">
                    @csrf

                    <div class="p-10">

                        <div
                            class="mb-8 flex flex-col items-center justify-between gap-4 rounded-2xl border border-slate-200 bg-slate-50 px-10 py-6 md:flex-row">

                            <div>
                                <h2 class="text-xl font-semibold text-slate-800">
                                    Business Information
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    These details will appear on your invoices and business profile.
                                </p>
                            </div>

                            <button
                                class="group inline-flex items-center gap-3
           rounded-full
           bg-gradient-to-r
           from-blue-300
           to-indigo-400
           px-9 py-4
           font-semibold text-white
           shadow-lg
           transition-all duration-300
           hover:shadow-blue-300/40
           hover:-translate-y-0.5">

                                <span>Continue</span>

                                <i data-lucide="arrow-right" class="h-5 w-5 transition-transform group-hover:translate-x-1">
                                </i>

                            </button>
                        </div>


                        <div class="grid gap-6 lg:grid-cols-2">

                            <!-- Business Name -->
                            <div class="lg:col-span-2">
                                <label for="business_name" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Business Name *
                                </label>

                                <input type="text" id="business_name" name="business_name"
                                    value="{{ old('business_name', auth()->user()->shop->name ?? '') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500"
                                    required>

                                @error('business_name')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Owner -->
                            <div>
                                <label for="owner_name" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Owner Name
                                </label>

                                <input type="text" id="owner_name" name="owner_name"
                                    value="{{ old('owner_name', auth()->user()->shop->owner_name ?? auth()->user()->name) }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Phone -->
                            <div>
                                <label for="phone" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Phone Number
                                </label>

                                <input type="text" id="phone" name="phone"
                                    value="{{ old('phone', auth()->user()->shop->phone ?? '') }}"
                                    placeholder="+91 XXXXX XXXXX"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Email -->
                            <div>
                                <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Business Email
                                </label>

                                <input type="email" id="email" name="email"
                                    value="{{ old('email', auth()->user()->shop->email ?? auth()->user()->email) }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- GST -->
                            <div>
                                <label for="gst" class="mb-2 block text-sm font-semibold text-slate-700">
                                    GST Number
                                </label>

                                <input type="text" id="gst" name="gst" value="{{ old('gst') }}"
                                    placeholder="Optional"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Address -->
                            <div class="lg:col-span-2">
                                <label for="address" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Business Address
                                </label>

                                <textarea id="address" name="address" rows="4"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('address', auth()->user()->shop->address ?? '') }}</textarea>

                                @error('address')
                                    <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- City -->
                            <div>
                                <label for="city" class="mb-2 block text-sm font-semibold text-slate-700">
                                    City
                                </label>

                                <input type="text" id="city" name="city"
                                    value="{{ old('city', auth()->user()->shop->city ?? '') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- State -->
                            <div>
                                <label for="state" class="mb-2 block text-sm font-semibold text-slate-700">
                                    State
                                </label>

                                <input type="text" id="state" name="state"
                                    value="{{ old('state', auth()->user()->shop->state ?? '') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Country -->
                            <div class="lg:col-span-2">
                                <label for="country" class="mb-2 block text-sm font-semibold text-slate-700">
                                    Country
                                </label>

                                <input type="text" id="country" name="country"
                                    value="{{ old('country', auth()->user()->shop->country ?? 'India') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                        </div>

                    </div>

                    <!-- Footer -->
                    <div
                        class="flex flex-col items-center justify-between gap-4 rounded-b-3xl bg-slate-50 px-10 py-6 md:flex-row">

                        <p class="text-sm text-slate-500">
                            You can update these details later from Business Settings.
                        </p>



                    </div>

                </form>

            </div>

        </div>

    </div>
@endsection
