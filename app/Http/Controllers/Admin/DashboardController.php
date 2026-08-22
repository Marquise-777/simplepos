<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Models\Subscription;
use App\Models\AdminActivityLog;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_shops' => Shop::count(),

            'active_shops' => Shop::where('status', 'active')->count(),

            'active_subscriptions' => Subscription::where('status', 'active')->count(),

            'monthly_revenue' => Subscription::where('status', 'active')
                ->where('billing_cycle', 'monthly')
                ->sum('amount'),
        ];

        $recentActivities = AdminActivityLog::with('adminUser', 'shop')
            ->latest()
            ->limit(10)
            ->get();

        $recentShops = Shop::latest()
            ->limit(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentActivities',
            'recentShops'
        ));
    }
}
