<x-app-layout>

    <x-slot name="header">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">
                Dashboard
            </h1>
            <p class="mt-1 text-sm text-slate-500">
                Welcome back, {{ auth()->user()->name }} 👋
            </p>
        </div>
    </x-slot>

    <div class="space-y-6">

        {{-- ===================== --}}
        {{-- STATISTICS --}}
        {{-- ===================== --}}

        <div class="grid gap-6 sm:grid-cols-2 xl:grid-cols-4">

            <x-stat-card title="Today's Sales" :value="'₹' . number_format($todaySales, 2)" icon="💰" trend="Completed sales today" />

            <x-stat-card title="Total Invoices" :value="number_format($invoiceCount)" icon="📄" trend="All completed invoices" />

            <x-stat-card title="Average Invoice" :value="'₹' . number_format($averageInvoice, 2)" icon="📊" trend="Average completed sale" />

            <x-stat-card title="Highest Invoice" :value="'₹' . number_format($highestInvoice, 2)" icon="🏆" trend="Highest completed sale" />

        </div>


        {{-- ===================== --}}
        {{-- SALES TREND + PAYMENTS --}}
        {{-- ===================== --}}

        <div class="grid gap-4 xl:grid-cols-3">

            {{-- Sales Trend --}}
            <div class="min-w-0 rounded-3xl border border-slate-200 bg-white p-4 sm:p-6 xl:col-span-2">

                <div>
                    <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
                        Sales Trend
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                        Last 7 days
                    </p>
                </div>

                <div class="relative mt-5 h-56 w-full sm:h-72">
                    <canvas id="salesTrendChart"></canvas>
                </div>

            </div>


            {{-- Payment Breakdown --}}
            <div class="min-w-0 rounded-3xl border border-slate-200 bg-white p-4 sm:p-6">

                <div>
                    <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
                        Payment Breakdown
                    </h2>

                    <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                        Completed sales
                    </p>
                </div>

                <div class="mx-auto mt-5 h-44 w-44 sm:h-52 sm:w-52">
                    <canvas id="paymentChart"></canvas>
                </div>

                <div class="mt-5 space-y-2">

                    @forelse ($paymentBreakdown as $method => $total)
                        <div class="flex items-center justify-between gap-3 text-xs sm:text-sm">

                            <span class="capitalize text-slate-500">
                                {{ $method }}
                            </span>

                            <span class="whitespace-nowrap font-semibold text-slate-900">
                                ₹{{ number_format($total, 2) }}
                            </span>

                        </div>

                    @empty

                        <p class="py-4 text-center text-xs text-slate-400">
                            No payment data yet.
                        </p>
                    @endforelse

                </div>

            </div>

        </div>
        {{-- ===================== --}}
        {{-- MONTHLY SALES --}}
        {{-- ===================== --}}

        <div class="rounded-3xl border border-slate-200 bg-white p-4 sm:p-6">

            <div>
                <h2 class="text-base font-semibold text-slate-900 sm:text-lg">
                    Monthly Sales
                </h2>

                <p class="mt-1 text-xs text-slate-500 sm:text-sm">
                    Sales performance this year
                </p>
            </div>

            <div class="relative mt-5 h-64 w-full sm:h-72">
                <canvas id="monthlySalesChart"></canvas>
            </div>

        </div>


        {{-- ===================== --}}
        {{-- RECENT SALES + QUICK ACTIONS --}}
        {{-- ===================== --}}

        <div class="grid gap-6 xl:grid-cols-3">

            {{-- Recent Sales --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6 xl:col-span-2">

                <div class="flex items-center justify-between">

                    <div>
                        <h2 class="text-lg font-semibold text-slate-900">
                            Recent Sales
                        </h2>

                        <p class="mt-1 text-sm text-slate-500">
                            Your latest completed transactions
                        </p>
                    </div>

                    <a href="{{ route('sales.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">
                        View All
                    </a>

                </div>


                <div class="mt-6 overflow-x-auto">

                    <table class="w-full text-left">

                        <thead>
                            <tr class="border-b border-slate-100 text-xs uppercase tracking-wide text-slate-400">

                                <th class="pb-3 font-medium">
                                    Invoice
                                </th>

                                <th class="pb-3 font-medium">
                                    Customer
                                </th>

                                <th class="pb-3 font-medium">
                                    Payment
                                </th>

                                <th class="pb-3 text-right font-medium">
                                    Amount
                                </th>

                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse ($recentSales as $sale)
                                <tr class="text-sm">

                                    <td class="py-4 font-medium text-slate-900">
                                        {{ $sale->invoice_no }}
                                    </td>

                                    <td class="py-4 text-slate-600">
                                        {{ $sale->customer?->name ?? 'Walk-in Customer' }}
                                    </td>

                                    <td class="py-4">

                                        <span
                                            class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium capitalize text-slate-600">
                                            {{ $sale->payment_method }}
                                        </span>

                                    </td>

                                    <td class="py-4 text-right font-semibold text-slate-900">
                                        ₹{{ number_format($sale->grand_total, 2) }}
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="4" class="py-12 text-center text-sm text-slate-400">
                                        No sales yet.
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Quick Actions --}}
            <div class="rounded-3xl border border-slate-200 bg-white p-6">

                <h2 class="text-lg font-semibold text-slate-900">
                    Quick Actions
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Common actions
                </p>

                <div class="mt-6 space-y-3">

                    <a href="{{ route('sales.index') }}" class="block">
                        <x-button variant="primary" size="md">
                            + New Sale
                        </x-button>
                    </a>

                    <a href="{{ route('sales.index') }}" class="block">
                        <x-button variant="ghost" size="md">
                            Sales History
                        </x-button>
                    </a>

                    <a href="{{ route('customers.index') }}" class="block">
                        <x-button variant="ghost" size="md">
                            Customers
                        </x-button>
                    </a>

                    <a href="{{ route('reports.index') }}" class="block">
                        <x-button variant="ghost" size="md">
                            Reports
                        </x-button>
                    </a>
                    <a href="{{ route('settings.index') }}" class="block">
                        <x-button variant="ghost" size="md">
                            Settings
                        </x-button>
                    </a>
                </div>

            </div>

        </div>

    </div>


    {{-- ===================== --}}
    {{-- CHART.JS --}}
    {{-- ===================== --}}

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        // ==========================
        // SALES TREND
        // ==========================

        const salesTrendData = @json($salesTrend);

        const salesLabels = salesTrendData.map(item => {
            return new Date(item.date + 'T00:00:00').toLocaleDateString('en-IN', {
                day: 'numeric',
                month: 'short'
            });
        });

        const salesValues = salesTrendData.map(item => Number(item.total));

        new Chart(document.getElementById('salesTrendChart'), {

            type: 'line',

            data: {
                labels: salesLabels,

                datasets: [{
                    label: 'Sales',
                    data: salesValues,

                    tension: 0.4,
                    fill: true,

                    borderWidth: 2,

                    pointRadius: 3,
                    pointHoverRadius: 5
                }]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ₹' + Number(context.raw).toLocaleString('en-IN', {
                                    minimumFractionDigits: 2
                                });
                            }
                        }
                    }
                },

                scales: {

                    y: {
                        beginAtZero: true,

                        ticks: {
                            maxTicksLimit: 6,

                            callback: function(value) {
                                return '₹' + Number(value).toLocaleString('en-IN');
                            }
                        },

                        grid: {
                            color: '#f1f5f9'
                        }
                    },

                    x: {
                        grid: {
                            display: false
                        },

                        ticks: {
                            maxTicksLimit: 7
                        }
                    }

                }
            }

        });


        // ==========================
        // PAYMENT BREAKDOWN
        // ==========================

        const paymentData = @json($paymentBreakdown);

        const paymentLabels = Object.keys(paymentData);

        const paymentValues = Object.values(paymentData)
            .map(value => Number(value));

        new Chart(document.getElementById('paymentChart'), {

            type: 'doughnut',

            data: {
                labels: paymentLabels,

                datasets: [{
                    data: paymentValues,
                    borderWidth: 0
                }]
            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                cutout: '68%',

                plugins: {
                    legend: {
                        display: false
                    },

                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                return ' ₹' + Number(context.raw).toLocaleString('en-IN', {
                                    minimumFractionDigits: 2
                                });
                            }
                        }
                    }
                }

            }

        });

        // ==========================
        // MONTHLY SALES
        // ==========================

        const monthlySalesData = @json($monthlySales);

        const monthNames = [
            'Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
            'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'
        ];

        const monthlyLabels = monthNames;

        const monthlyValues = monthNames.map((month, index) => {

            const monthNumber = index + 1;

            const record = monthlySalesData.find(item =>
                Number(item.month) === monthNumber
            );

            return record ? Number(record.total) : 0;
        });


        new Chart(document.getElementById('monthlySalesChart'), {

            type: 'bar',

            data: {

                labels: monthlyLabels,

                datasets: [{
                    label: 'Sales',

                    data: monthlyValues,

                    borderWidth: 0,

                    borderRadius: 8,

                    barPercentage: 0.65,

                    categoryPercentage: 0.75
                }]

            },

            options: {

                responsive: true,
                maintainAspectRatio: false,

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                return ' ₹' + Number(context.raw)
                                    .toLocaleString('en-IN', {
                                        minimumFractionDigits: 2
                                    });

                            }

                        }

                    }

                },

                scales: {

                    y: {

                        beginAtZero: true,

                        ticks: {

                            maxTicksLimit: 6,

                            callback: function(value) {

                                return '₹' + Number(value)
                                    .toLocaleString('en-IN');

                            }

                        },

                        grid: {
                            color: '#f1f5f9'
                        }

                    },

                    x: {

                        grid: {
                            display: false
                        }

                    }

                }

            }

        });
    </script>

</x-app-layout>
