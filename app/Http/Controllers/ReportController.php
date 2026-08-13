<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    public function index()
    {
        return view('reports.index');
    }

    public function sales(Request $request)
    {
        $user = Auth::user();

        $query = Sale::with(['customer', 'user'])
            ->where('shop_id', $user->shop_id);

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        // Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('invoice_no', 'like', "%{$search}%")
                    ->orWhereHas('customer', function ($customer) use ($search) {
                        $customer->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $sales = $query
            ->latest('invoice_date')
            ->paginate(20)
            ->withQueryString();

        // Summary
        $summaryQuery = Sale::where('shop_id', $user->shop_id);

        if ($request->filled('date_from')) {
            $summaryQuery->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $summaryQuery->whereDate('invoice_date', '<=', $request->date_to);
        }

        if ($request->filled('status') && $request->status !== 'all') {
            $summaryQuery->where('status', $request->status);
        }

        $summary = [
            'total_sales' => (clone $summaryQuery)
                ->where('status', 'completed')
                ->sum('grand_total'),

            'invoice_count' => (clone $summaryQuery)
                ->where('status', 'completed')
                ->count(),

            'average_invoice' => (clone $summaryQuery)
                ->where('status', 'completed')
                ->avg('grand_total') ?? 0,

            'cancelled' => (clone $summaryQuery)
                ->where('status', 'cancelled')
                ->count(),

            'refunded' => (clone $summaryQuery)
                ->where('status', 'refunded')
                ->count(),
        ];

        return view('reports.sales', compact(
            'sales',
            'summary'
        ));
    }

    public function payments(Request $request)
    {
        $user = Auth::user();

        $query = Sale::where('shop_id', $user->shop_id)
            ->where('status', 'completed');

        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $payments = $query
            ->selectRaw('payment_method, COUNT(*) as count, SUM(grand_total) as total')
            ->groupBy('payment_method')
            ->orderByDesc('total')
            ->get();

        return view('reports.payments', compact('payments'));
    }

    public function daily(Request $request)
    {
        $user = Auth::user();

        $dateFrom = $request->date_from
            ?? now()->startOfMonth()->toDateString();

        $dateTo = $request->date_to
            ?? now()->toDateString();

        $daily = Sale::where('shop_id', $user->shop_id)
            ->where('status', 'completed')
            ->whereDate('invoice_date', '>=', $dateFrom)
            ->whereDate('invoice_date', '<=', $dateTo)
            ->selectRaw('
                DATE(invoice_date) as date,
                COUNT(*) as invoice_count,
                SUM(grand_total) as total_sales
            ')
            ->groupByRaw('DATE(invoice_date)')
            ->orderBy('date')
            ->get();

        return view('reports.daily', compact(
            'daily',
            'dateFrom',
            'dateTo'
        ));
    }

    public function monthly(Request $request)
    {
        $user = Auth::user();

        $year = $request->year ?? now()->year;

        $monthly = Sale::where('shop_id', $user->shop_id)
            ->where('status', 'completed')
            ->whereYear('invoice_date', $year)
            ->selectRaw('
                MONTH(invoice_date) as month,
                COUNT(*) as invoice_count,
                SUM(grand_total) as total_sales
            ')
            ->groupByRaw('MONTH(invoice_date)')
            ->orderBy('month')
            ->get();

        return view('reports.monthly', compact(
            'monthly',
            'year'
        ));
    }
}
