<x-app-layout>

    <div class="space-y-6">

        <div>
            <h1 class="text-2xl font-semibold text-slate-900">
                Reports
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Analyze your business performance in detail.
            </p>
        </div>

        <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">

            <a href="{{ route('reports.sales') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-blue-600">
                    <i data-lucide="chart-column"></i>
                </div>

                <h2 class="font-semibold text-slate-900">
                    Sales Report
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Analyze sales, invoices and transaction status.
                </p>

            </a>

            <a href="{{ route('reports.payments') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-emerald-50 text-emerald-600">
                    <i data-lucide="wallet"></i>
                </div>

                <h2 class="font-semibold text-slate-900">
                    Payment Report
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    See how customers are paying.
                </p>

            </a>

            <a href="{{ route('reports.daily') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-violet-50 text-violet-600">
                    <i data-lucide="calendar-days"></i>
                </div>

                <h2 class="font-semibold text-slate-900">
                    Daily Report
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Compare sales performance by day.
                </p>

            </a>

            <a href="{{ route('reports.monthly') }}"
                class="group rounded-2xl border border-slate-200 bg-white p-6 shadow-sm transition hover:-translate-y-1 hover:shadow-md">

                <div class="mb-4 flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-orange-600">
                    <i data-lucide="calendar-range"></i>
                </div>

                <h2 class="font-semibold text-slate-900">
                    Monthly Report
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Compare monthly business performance.
                </p>

            </a>

        </div>

    </div>

</x-app-layout>
