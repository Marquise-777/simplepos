<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use App\Models\PaymentInstallment;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(Request $request): JsonResponse
    {
        $shopId = $request->user()->shop_id;

        /*
        |--------------------------------------------------------------------------
        | Activity notifications
        |--------------------------------------------------------------------------
        */

        $activityNotifications = ActivityLog::where('shop_id', $shopId)
            ->latest()
            ->limit(10)
            ->get()
            ->map(function ($notification) {
                return [
                    'id' => 'activity-' . $notification->id,
                    'title' => $this->formatTitle($notification->action),
                    'message' => $notification->description,
                    'time' => $notification->created_at
                        ? $notification->created_at->diffForHumans()
                        : 'Just now',
                    'unread' => is_null($notification->read_at),
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Credit / EMI due notifications
        |--------------------------------------------------------------------------
        */

        $installments = PaymentInstallment::with([
            'paymentPlan.sale.customer',
        ])
            ->whereHas('paymentPlan.sale', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->whereDate('due_date', '<=', today()->addDays(3))
            ->get();

        $creditNotifications = $installments
            ->map(function ($installment) {

                $remaining = max(
                    0,
                    (float) $installment->amount -
                        (float) $installment->paid_amount
                );

                if ($remaining <= 0) {
                    return null;
                }

                $customerName = $installment->paymentPlan->sale->customer->name
                    ?? 'Customer';

                $dueDate = $installment->due_date->startOfDay();
                $today = today();

                if ($dueDate->lt($today)) {

                    $days = $dueDate->diffInDays($today);

                    return [
                        'id' => 'credit-overdue-' . $installment->id,
                        'title' => 'Credit payment overdue',
                        'message' => "{$customerName} has ₹" .
                            number_format($remaining, 2) .
                            " overdue.",
                        'time' => $days === 1
                            ? '1 day overdue'
                            : "{$days} days overdue",
                        'unread' => true,
                        'priority' => 1,
                    ];
                }

                if ($dueDate->isToday()) {

                    return [
                        'id' => 'credit-due-' . $installment->id,
                        'title' => 'Credit payment due today',
                        'message' => "{$customerName} has ₹" .
                            number_format($remaining, 2) .
                            " due today.",
                        'time' => 'Due today',
                        'unread' => true,
                        'priority' => 2,
                    ];
                }

                $days = $today->diffInDays($dueDate);

                return [
                    'id' => 'credit-soon-' . $installment->id,
                    'title' => 'Credit payment due soon',
                    'message' => "{$customerName} has ₹" .
                        number_format($remaining, 2) .
                        " due.",
                    'time' => $days === 1
                        ? 'Due tomorrow'
                        : "Due in {$days} days",
                    'unread' => true,
                    'priority' => 3,
                ];
            })
            ->filter()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Combine
        |--------------------------------------------------------------------------
        */

        $notifications = $activityNotifications
            ->concat($creditNotifications)
            ->sortBy([
                ['unread', 'desc'],
                ['priority', 'asc'],
            ])
            ->take(10)
            ->values();

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $notifications
                ->where('unread', true)
                ->count(),
        ]);
    }

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
            'shop_created' => 'Shop created',
            'shop_setup_completed' => 'Shop setup completed',
            'sale_created' => 'New sale completed',
            'payment_received' => 'Payment received',
            'sale_cancelled' => 'Sale cancelled',
            'sale_refunded' => 'Sale refunded',
            'credit_created' => 'Credit sale recorded',
            'installment_due' => 'Installment due',
            'installment_overdue' => 'Installment overdue',
            default => ucwords(str_replace('_', ' ', $action)),
        };
    }
}
