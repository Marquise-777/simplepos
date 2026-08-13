<?php

namespace App\Http\Controllers;

use App\Models\PaymentInstallment;
use App\Models\PaymentPlan;
use App\Models\SalePayment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CreditEmiController extends Controller
{
    public function index()
    {
        $shopId = auth()->user()->shop_id;

        $filter = request('filter');
        $search = request('search');

        /*
    |--------------------------------------------------------------------------
    | ALL PLANS — used for dashboard statistics
    |--------------------------------------------------------------------------
    */

        $allPlans = PaymentPlan::with([
            'sale.payments',
            'installments',
        ])
            ->whereHas('sale', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->get();

        $outstanding = $allPlans->sum(function ($plan) {
            $paid = $plan->sale->payments->sum('amount');

            return max(
                0,
                (float) $plan->total_payable - (float) $paid
            );
        });

        $dueToday = $allPlans->sum(function ($plan) {
            return $plan->installments
                ->where('due_date', today())
                ->whereIn('status', ['pending', 'partial'])
                ->sum(function ($installment) {
                    return max(
                        0,
                        (float) $installment->amount -
                            (float) $installment->paid_amount
                    );
                });
        });

        $overdue = $allPlans->sum(function ($plan) {
            return $plan->installments
                ->where('due_date', '<', today())
                ->whereIn('status', ['pending', 'partial', 'overdue'])
                ->sum(function ($installment) {
                    return max(
                        0,
                        (float) $installment->amount -
                            (float) $installment->paid_amount
                    );
                });
        });


        /*
    |--------------------------------------------------------------------------
    | PLANS — used for table
    |--------------------------------------------------------------------------
    */

        $plans = PaymentPlan::with([
            'sale.customer',
            'sale.payments',
            'installments',
        ])
            ->whereHas('sale', function ($query) use ($shopId) {
                $query->where('shop_id', $shopId);
            })
            ->when($search, function ($query) use ($search) {
                $query->whereHas('sale.customer', function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->when($filter === 'due', function ($query) {
                $query->whereHas('installments', function ($q) {
                    $q->whereDate('due_date', today())
                        ->whereIn('status', ['pending', 'partial']);
                });
            })
            ->when($filter === 'overdue', function ($query) {
                $query->whereHas('installments', function ($q) {
                    $q->whereDate('due_date', '<', today())
                        ->whereIn('status', ['pending', 'partial', 'overdue']);
                });
            })
            ->latest()
            ->get();

        return view('credit-emi.index', compact(
            'plans',
            'outstanding',
            'dueToday',
            'overdue'
        ));
    }

    public function show(PaymentPlan $paymentPlan)
    {
        $shopId = auth()->user()->shop_id;

        $paymentPlan->load([
            'sale.customer',
            'sale.payments',
            'installments',
        ]);

        abort_unless(
            $paymentPlan->sale->shop_id === $shopId,
            403
        );

        $paid = $paymentPlan->sale->payments->sum('amount');

        $outstanding = max(
            0,
            (float) $paymentPlan->total_payable - (float) $paid
        );

        return view('credit-emi.show', compact(
            'paymentPlan',
            'paid',
            'outstanding'
        ));
    }
    public function recordPayment(Request $request, PaymentPlan $paymentPlan)
    {
        $request->validate([
            'installment_id' => ['required', 'exists:payment_installments,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'payment_method' => ['required', 'in:cash,upi,bank,card,mixed'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ]);

        $paymentPlan->load('sale');

        abort_unless(
            $paymentPlan->sale->shop_id === auth()->user()->shop_id,
            403
        );

        $installment = PaymentInstallment::where('id', $request->installment_id)
            ->where('payment_plan_id', $paymentPlan->id)
            ->firstOrFail();

        $remaining = max(
            0,
            (float) $installment->amount - (float) $installment->paid_amount
        );

        if ((float) $request->amount > $remaining) {
            return back()->withErrors([
                'amount' => 'Payment cannot be greater than the installment balance.',
            ]);
        }

        DB::transaction(function () use ($request, $paymentPlan, $installment) {

            SalePayment::create([
                'sale_id' => $paymentPlan->sale_id,
                'amount' => $request->amount,
                'payment_method' => $request->payment_method,
                'paid_at' => now(),
                'notes' => $request->notes,
            ]);

            $paidAmount = (float) $installment->paid_amount
                + (float) $request->amount;

            $installment->update([
                'paid_amount' => $paidAmount,
                'status' => $paidAmount >= (float) $installment->amount
                    ? 'paid'
                    : 'partial',
                'paid_at' => $paidAmount >= (float) $installment->amount
                    ? now()
                    : null,
            ]);

            $totalPaid = $paymentPlan->sale
                ->payments()
                ->sum('amount') + (float) $request->amount;

            if ($totalPaid >= (float) $paymentPlan->total_payable) {
                $paymentPlan->update([
                    'status' => 'completed',
                ]);
            }
        });

        return back()->with(
            'success',
            'Payment recorded successfully.'
        );
    }
}
