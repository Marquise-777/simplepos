<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;

class ActivityLogController extends Controller
{
    public function index(Request $request)
    {
        $shopId = $request->user()->shop_id;

        $logs = ActivityLog::with('user')
            ->where('shop_id', $shopId)

            ->when($request->search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('action', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('user', function ($userQuery) use ($search) {
                            $userQuery->where('name', 'like', "%{$search}%");
                        });
                });
            })

            ->when($request->action, function ($query, $action) {
                $query->where('action', $action);
            })

            ->latest()
            ->paginate(20)
            ->withQueryString();

        $actions = ActivityLog::where('shop_id', $shopId)
            ->select('action')
            ->distinct()
            ->orderBy('action')
            ->pluck('action');

        return view('activity-logs.index', compact(
            'logs',
            'actions'
        ));
    }
}
