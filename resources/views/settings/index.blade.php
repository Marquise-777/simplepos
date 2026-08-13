<x-app-layout>
    <div class="space-y-6">

        {{-- Header --}}
        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Settings
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Manage your business and invoice preferences.
            </p>
        </div>

        {{-- Flash --}}
        @if (session('success'))
            <div class="rounded-xl border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('settings.update') }}" enctype="multipart/form-data" class="space-y-6">

            @csrf
            @method('PUT')

            {{-- Business Information --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Business Information
                    </h2>
                    <p class="text-sm text-slate-500">
                        Information shown on your invoices.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Business Name
                        </label>

                        <input type="text" name="business_name"
                            value="{{ old('business_name', $settings->business_name) }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                            required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Phone
                        </label>

                        <input type="text" name="phone" value="{{ old('phone', $settings->phone) }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Email
                        </label>

                        <input type="email" name="email" value="{{ old('email', $settings->email) }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div class="md:col-span-2">
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Address
                        </label>

                        <textarea name="address" rows="3"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">{{ old('address', $settings->address) }}</textarea>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            GST Number
                        </label>

                        <input type="text" name="gst" value="{{ old('gst', $settings->gst) }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            FSSAI Number
                        </label>

                        <input type="text" name="fssai" value="{{ old('fssai', $settings->fssai) }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                    </div>

                </div>
            </div>

            {{-- Logo --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-slate-900">
                    Business Logo
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    This logo will appear on your invoices.
                </p>

                <div class="mt-5 flex items-center gap-5">

                    @if ($settings->logo)
                        <img src="{{ Storage::url($settings->logo) }}"
                            class="h-20 w-20 rounded-2xl border border-slate-200 object-contain p-2">
                    @else
                        <div class="flex h-20 w-20 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">
                            No Logo
                        </div>
                    @endif

                    <div>
                        <input type="file" name="logo" accept="image/png,image/jpeg,image/webp"
                            class="block w-full text-sm text-slate-500 file:mr-4 file:rounded-xl file:border-0 file:bg-blue-50 file:px-4 file:py-2 file:text-sm file:font-medium file:text-blue-700 hover:file:bg-blue-100">

                        <p class="mt-2 text-xs text-slate-400">
                            PNG, JPG or WEBP. Maximum 2MB.
                        </p>
                    </div>

                </div>
            </div>

            {{-- Invoice Settings --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Invoice Settings
                    </h2>
                    <p class="text-sm text-slate-500">
                        Customize how your invoices are generated.
                    </p>
                </div>

                <div class="grid gap-5 md:grid-cols-2">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Invoice Prefix
                        </label>

                        <input type="text" name="invoice_prefix"
                            value="{{ old('invoice_prefix', $settings->invoice_prefix ?? 'INV') }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                            required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Currency
                        </label>

                        <input type="text" name="currency" value="{{ old('currency', $settings->currency ?? '₹') }}"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                            required>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Invoice Template
                        </label>

                        <select name="invoice_template"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="classic" @selected($settings->invoice_template === 'classic')>Classic</option>
                            <option value="modern" @selected($settings->invoice_template === 'modern')>Modern</option>
                            <option value="thermal58" @selected($settings->invoice_template === 'thermal58')>Thermal 58mm</option>
                            <option value="thermal80" @selected($settings->invoice_template === 'thermal80')>Thermal 80mm</option>
                            <option value="a4" @selected($settings->invoice_template === 'a4')>A4</option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Paper Size
                        </label>

                        <select name="paper_size"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="thermal58" @selected($settings->paper_size === 'thermal58')>Thermal 58mm</option>
                            <option value="thermal80" @selected($settings->paper_size === 'thermal80')>Thermal 80mm</option>
                            <option value="a4" @selected($settings->paper_size === 'a4')>A4</option>
                        </select>
                    </div>

                </div>
            </div>

            {{-- Regional --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-semibold text-slate-900">
                        Regional Settings
                    </h2>
                </div>

                <div class="grid gap-5 md:grid-cols-3">

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Timezone
                        </label>

                        <select name="timezone"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="Asia/Kolkata" @selected($settings->timezone === 'Asia/Kolkata')>
                                India — Asia/Kolkata
                            </option>
                            <option value="UTC" @selected($settings->timezone === 'UTC')>
                                UTC
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Date Format
                        </label>

                        <select name="date_format"
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100">
                            <option value="d M Y" @selected($settings->date_format === 'd M Y')>
                                10 Aug 2026
                            </option>
                            <option value="d/m/Y" @selected($settings->date_format === 'd/m/Y')>
                                10/08/2026
                            </option>
                            <option value="Y-m-d" @selected($settings->date_format === 'Y-m-d')>
                                2026-08-10
                            </option>
                        </select>
                    </div>

                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">
                            Theme Color
                        </label>

                        <input type="color" name="primary_color"
                            value="{{ old('primary_color', $settings->primary_color ?? '#2563eb') }}"
                            class="h-11 w-full cursor-pointer rounded-xl border border-slate-200 bg-slate-50 p-1">
                    </div>

                </div>
            </div>

            {{-- Footer --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <h2 class="text-lg font-semibold text-slate-900">
                    Invoice Footer
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Optional message displayed at the bottom of invoices.
                </p>

                <textarea name="footer_text" rows="3"
                    class="mt-5 w-full rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm focus:border-blue-500 focus:bg-white focus:outline-none focus:ring-2 focus:ring-blue-100"
                    placeholder="Thank you for your business!">{{ old('footer_text', $settings->footer_text) }}</textarea>

            </div>

            {{-- Save --}}
            <div class="flex justify-end">
                <button type="submit"
                    class="rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 px-6 py-3 text-sm font-medium text-white shadow-sm transition hover:scale-[1.02]">
                    Save Settings
                </button>
            </div>

        </form>
    </div>
</x-app-layout>
