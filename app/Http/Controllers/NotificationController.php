<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    /**
     * Get recent notifications for the current shop.
     */
    public function index(Request $request): JsonResponse
    {
        $shopId = $request->user()->shop_id;

        $notifications = ActivityLog::where('shop_id', $shopId)
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => $notification->id,
                    'title' => $this->formatTitle($notification->action),
                    'message' => $notification->description,
                    'time' => $notification->created_at->diffForHumans(),
                    'unread' => is_null($notification->read_at),
                ];
            });

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $notifications->where('unread', true)->count(),
        ]);
    }

    /**
     * Mark all shop notifications as read.
     */
    public function markAllRead(Request $request): JsonResponse
    {
        ActivityLog::where('shop_id', $request->user()->shop_id)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }

    private function formatTitle(string $action): string
    {
        return match ($action) {
            'sale_created' => 'New sale completed',
            'payment_received' => 'Payment received',
            'sale_cancelled' => 'Sale cancelled',
            'credit_created' => 'Credit sale recorded',
            'installment_due' => 'Installment due',
            'installment_overdue' => 'Installment overdue',
            default => ucwords(str_replace('_', ' ', $action)),
        };
    }
}
