@extends('layouts.setup')

@section('title', 'Invoice Setup')

@section('content')

    <div class="min-h-screen bg-slate-100 py-12 px-6">

        <div class="mx-auto max-w-4xl">

            <!-- Header -->
            <div class="mb-10 text-center">

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
                            class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full bg-blue-600 text-white shadow">
                            <i data-lucide="check" class="h-5 w-5"></i>
                        </div>

                        <!-- Step 3 -->
                        <div
                            class="relative z-10 flex h-10 w-10 items-center justify-center rounded-full border-2 border-slate-300 bg-white text-slate-400">
                            3
                        </div>

                    </div>

                </div>

                <h1 class="mt-5 text-4xl font-bold text-slate-900">
                    Invoice & Preferences
                </h1>

                <p class="mt-3 text-lg text-slate-500">
                    Configure how your invoices will look.
                </p>

            </div>

            <div class="rounded-3xl bg-white shadow-xl">

                <form method="POST" action="{{ route('setup.invoice.store') }}">
                    @csrf

                    <div class="p-10">
                        <div class="flex items-center justify-between rounded-b-3xl  bg-slate-50 px-10 py-6">

                            <a href="{{ route('setup.business') }}"
                                class="group inline-flex items-center gap-3
           rounded-full
           bg-gradient-to-r
           
           px-9 py-4
           font-semibold text-gray-400
           shadow-lg
           transition-all duration-300
           hover:shadow-blue-300/40
           hover:-translate-y-0.5"">

                                ← Back

                            </a>

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
                        <div class="mb-8">
                            <h2 class="text-xl font-semibold text-slate-800">
                                Invoice Configuration
                            </h2>

                            <p class="mt-1 text-sm text-slate-500">
                                These settings can be changed anytime from Business Settings.
                            </p>
                        </div>

                        <div class="grid gap-6 md:grid-cols-2">

                            <!-- Invoice Prefix -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Invoice Prefix
                                </label>

                                <input type="text" name="invoice_prefix"
                                    value="{{ old('invoice_prefix', auth()->user()->shop->setting->invoice_prefix ?? 'INV') }}"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">
                            </div>

                            <!-- Currency -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Currency
                                </label>

                                <select name="currency" class="w-full rounded-xl border border-slate-300 px-4 py-3">

                                    <option value="INR">Indian Rupee (INR)</option>
                                    <option value="USD">US Dollar (USD)</option>
                                    <option value="EUR">Euro (EUR)</option>

                                </select>
                            </div>

                            <!-- Invoice Template -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Invoice Template
                                </label>

                                <select name="invoice_template" class="w-full rounded-xl border border-slate-300 px-4 py-3">

                                    <option value="classic">Classic</option>
                                    <option value="modern">Modern</option>
                                    <option value="thermal58">Thermal 58mm</option>
                                    <option value="thermal80">Thermal 80mm</option>
                                    <option value="a4">A4</option>

                                </select>
                            </div>

                            <!-- Paper Size -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Paper Size
                                </label>

                                <select name="paper_size" class="w-full rounded-xl border border-slate-300 px-4 py-3">

                                    <option value="thermal58">58 mm</option>
                                    <option value="thermal80">80 mm</option>
                                    <option value="a4" selected>A4</option>

                                </select>
                            </div>

                            <!-- Timezone -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Timezone
                                </label>

                                <select name="timezone" class="w-full rounded-xl border border-slate-300 px-4 py-3">

                                    <option value="Asia/Kolkata">
                                        Asia / Kolkata
                                    </option>

                                </select>
                            </div>

                            <!-- Theme -->
                            <div>
                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Theme Color
                                </label>

                                <input type="color" name="primary_color" value="{{ old('primary_color', '#2563eb') }}"
                                    class="h-12 w-full rounded-xl border border-slate-300">
                            </div>

                            <!-- Footer -->
                            <div class="md:col-span-2">

                                <label class="mb-2 block text-sm font-semibold text-slate-700">
                                    Invoice Footer
                                </label>

                                <textarea name="footer_text" rows="3"
                                    class="w-full rounded-xl border border-slate-300 px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-500">{{ old('footer_text') }}</textarea>

                            </div>

                        </div>

                    </div>



                </form>

            </div>

        </div>

    </div>

@endsection
