<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $todaySales = Sale::where('shop_id', Auth::user()->shop_id)
            ->whereDate('invoice_date', Carbon::today())
            ->where('status', 'completed')
            ->sum('grand_total');

        return view('dashboard', compact('todaySales'));
    }
}
