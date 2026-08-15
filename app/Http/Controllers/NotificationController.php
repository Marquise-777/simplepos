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

        $page = max(1, (int) $request->get('page', 1));
        $perPage = 10;

        $notificationActions = [
            'sale_created',
            'payment_received',
            'sale_cancelled',
            'sale_refunded',
            'credit_created',
        ];

        /*
        |--------------------------------------------------------------------------
        | Activity notifications
        |--------------------------------------------------------------------------
        */

        $activityNotifications = ActivityLog::where('shop_id', $shopId)
            ->whereIn('action', $notificationActions)
            ->latest()
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
                    'priority' => 4,
                    'sort_time' => $notification->created_at?->timestamp ?? 0,
                ];
            });

        /*
        |--------------------------------------------------------------------------
        | Credit / EMI notifications
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

                $customerName = $installment
                    ->paymentPlan
                    ->sale
                    ->customer
                    ->name ?? 'Customer';

                $dueDate = $installment->due_date->startOfDay();
                $today = today();

                $unread = is_null($installment->notification_read_at);

                if ($dueDate->lt($today)) {

                    $days = $dueDate->diffInDays($today);

                    return [
                        'id' => 'credit-overdue-' . $installment->id,
                        'type' => 'credit',
                        'installment_id' => $installment->id,
                        'title' => 'Credit payment overdue',
                        'message' => "{$customerName} has ₹" .
                            number_format($remaining, 2) .
                            " overdue.",
                        'time' => $days === 1
                            ? '1 day overdue'
                            : "{$days} days overdue",
                        'unread' => $unread,
                        'priority' => 1,
                        'sort_time' => $dueDate->timestamp,
                    ];
                }

                if ($dueDate->isToday()) {

                    return [
                        'id' => 'credit-due-' . $installment->id,
                        'type' => 'credit',
                        'installment_id' => $installment->id,
                        'title' => 'Credit payment due today',
                        'message' => "{$customerName} has ₹" .
                            number_format($remaining, 2) .
                            " due today.",
                        'time' => 'Due today',
                        'unread' => $unread,
                        'priority' => 2,
                        'sort_time' => $dueDate->timestamp,
                    ];
                }

                $days = $today->diffInDays($dueDate);

                return [
                    'id' => 'credit-soon-' . $installment->id,
                    'type' => 'credit',
                    'installment_id' => $installment->id,
                    'title' => 'Credit payment due soon',
                    'message' => "{$customerName} has ₹" .
                        number_format($remaining, 2) .
                        " due.",
                    'time' => $days === 1
                        ? 'Due tomorrow'
                        : "Due in {$days} days",
                    'unread' => $unread,
                    'priority' => 3,
                    'sort_time' => $dueDate->timestamp,
                ];
            })
            ->filter()
            ->values();

        /*
        |--------------------------------------------------------------------------
        | Combine
        |--------------------------------------------------------------------------
        */

        $allNotifications = $activityNotifications
            ->concat($creditNotifications)
            ->sortBy([
                ['unread', 'desc'],
                ['priority', 'asc'],
                ['sort_time', 'desc'],
            ])
            ->values();

        $unreadCount = $allNotifications
            ->where('unread', true)
            ->count();

        $total = $allNotifications->count();

        $notifications = $allNotifications
            ->slice(($page - 1) * $perPage, $perPage)
            ->values();

        $hasMore = ($page * $perPage) < $total;

        return response()->json([
            'notifications' => $notifications,
            'unreadCount' => $unreadCount,
            'pagination' => [
                'currentPage' => $page,
                'perPage' => $perPage,
                'total' => $total,
                'lastPage' => (int) ceil($total / $perPage),
                'hasMore' => $hasMore,
            ],
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Mark all notifications as read
    |--------------------------------------------------------------------------
    */

    public function markAllRead(Request $request): JsonResponse
    {
        $shopId = $request->user()->shop_id;

        // Activity notifications
        ActivityLog::where('shop_id', $shopId)
            ->whereNull('read_at')
            ->update([
                'read_at' => now(),
            ]);

        // Credit / EMI notifications
        PaymentInstallment::whereHas('paymentPlan.sale', function ($query) use ($shopId) {
            $query->where('shop_id', $shopId);
        })
            ->whereIn('status', ['pending', 'partial', 'overdue'])
            ->whereDate('due_date', '<=', today()->addDays(3))
            ->whereNull('notification_read_at')
            ->update([
                'notification_read_at' => now(),
            ]);

        return response()->json([
            'success' => true,
        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | Mark one credit notification as read
    |--------------------------------------------------------------------------
    */

    public function markCreditRead(
        Request $request,
        PaymentInstallment $installment
    ): JsonResponse {
        $installment->load('paymentPlan.sale');

        abort_unless(
            $installment->paymentPlan->sale->shop_id === $request->user()->shop_id,
            403
        );

        $installment->update([
            'notification_read_at' => now(),
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
            'sale_refunded' => 'Sale refunded',
            'credit_created' => 'Credit sale recorded',
            default => ucwords(str_replace('_', ' ', $action)),
        };
    }
}
