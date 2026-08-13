<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $shopId = Auth::user()->shop_id;

        // Today's sales
        $todaySales = Sale::where('shop_id', $shopId)
            ->whereDate('invoice_date', Carbon::today())
            ->where('status', 'completed')
            ->sum('grand_total');

        // Total completed invoices
        $invoiceCount = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->count();

        // Average invoice value
        $averageInvoice = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->avg('grand_total') ?? 0;

        // Highest invoice
        $highestInvoice = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->max('grand_total') ?? 0;

        // Recent sales
        $recentSales = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->with('customer')
            ->latest('invoice_date')
            ->take(5)
            ->get();

        // Payment breakdown
        $paymentBreakdown = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->selectRaw('payment_method, SUM(grand_total) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        // Sales trend - last 7 days
        $salesTrend = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->whereDate('invoice_date', '>=', Carbon::today()->subDays(6))
            ->selectRaw('DATE(invoice_date) as date, SUM(grand_total) as total')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Monthly sales
        $monthlySales = Sale::where('shop_id', $shopId)
            ->where('status', 'completed')
            ->whereYear('invoice_date', Carbon::today()->year)
            ->selectRaw('MONTH(invoice_date) as month, SUM(grand_total) as total')
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('dashboard', compact(
            'todaySales',
            'invoiceCount',
            'averageInvoice',
            'highestInvoice',
            'recentSales',
            'paymentBreakdown',
            'salesTrend',
            'monthlySales'
        ));
    }
}
