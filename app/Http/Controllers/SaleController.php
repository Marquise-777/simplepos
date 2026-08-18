<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoiceSequence;
use App\Models\PaymentPlan;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Setting;
use App\Models\ActivityLog;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Sale::with([
            'customer',
            'user',
            'saleItems',
            'payments',
        ])
            ->where('shop_id', $user->shop_id);

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

        // Status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Date range
        if ($request->filled('date_from')) {
            $query->whereDate('invoice_date', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('invoice_date', '<=', $request->date_to);
        }

        $sales = $query
            ->latest('invoice_date')
            ->paginate(15)
            ->withQueryString();

        $customers = Customer::where('shop_id', $user->shop_id)
            ->orderBy('name')
            ->get();

        return view('sales.index', compact('sales', 'customers'));
    }

    public function create()
    {
        $user = Auth::user();

        $customers = Customer::query()
            ->where('shop_id', $user?->shop_id)
            ->latest()
            ->get();

        return view('sales.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'customer_id' => ['nullable', 'exists:customers,id'],
            'payment_method' => ['required', 'in:cash,upi,bank,card,mixed'],
            'amount_paid' => ['required', 'numeric', 'min:0'],
            // frontend posts discount_type and discount_value
            'discount_type' => ['nullable', 'in:fixed,percentage'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'tax_rate' => ['nullable', 'numeric', 'min:0'],
            'invoice_date' => ['required', 'date'],
            'status' => ['required', 'in:draft,completed'],
            'notes' => ['nullable', 'string'],

            'items' => ['required', 'array', 'min:1'],
            'items.*.item_name' => ['required', 'string', 'max:255'],
            'items.*.quantity' => ['required', 'numeric', 'min:0.01'],
            'items.*.rate' => ['required', 'numeric', 'min:0'],
        ]);

        $shop = $user?->shop;

        if (! $shop) {
            return redirect()->back()
                ->withErrors(['shop' => 'No shop is linked to this account.'])
                ->withInput();
        }

        // Make sure the selected customer belongs to this shop
        if (! empty($validated['customer_id'])) {

            $customerExists = Customer::where('id', $validated['customer_id'])
                ->where('shop_id', $shop->id)
                ->exists();

            if (! $customerExists) {
                return redirect()->back()
                    ->withErrors([
                        'customer_id' => 'Invalid customer selected.'
                    ])
                    ->withInput();
            }
        }

        $sale = DB::transaction(function () use ($validated, $user, $shop) {


            $sequence = InvoiceSequence::firstOrCreate(
                [
                    'shop_id' => $shop->id,
                    'year' => now()->year,
                    'month' => now()->month,
                ],
                [
                    'current_number' => 0,
                ]
            );

            $sequence->increment('current_number');

            $sequence->refresh();

            $settings = Setting::firstOrCreate(
                ['shop_id' => $shop->id],
                ['invoice_prefix' => 'INV']
            );

            $prefix = strtoupper(trim($settings->invoice_prefix ?: 'INV'));

            $invoiceNumber = $prefix . '-' . now()->format('Ymd') . '-' .
                str_pad(
                    (string) $sequence->current_number,
                    4,
                    '0',
                    STR_PAD_LEFT
                );

            $subtotal = 0;

            foreach ($validated['items'] as $item) {

                $quantity = (float) $item['quantity'];
                $rate = (float) $item['rate'];

                $subtotal += $quantity * $rate;
            }

            // compute discount from frontend fields (supports fixed and percentage)
            $discountType = $validated['discount_type'] ?? 'fixed';
            $discountValue = (float) ($validated['discount_value'] ?? 0);

            // Backwards-compat: support legacy `discount` field if present
            if (array_key_exists('discount', $validated)) {
                $discountValue = (float) $validated['discount'];
                $discountType = 'fixed';
            }

            if ($discountType === 'percentage') {
                $discount = round(($subtotal * $discountValue) / 100, 2);
            } else {
                $discount = round($discountValue, 2);
            }

            if ($discount > $subtotal) {
                throw \Illuminate\Validation\ValidationException::withMessages([
                    'discount_value' => 'Discount cannot be greater than the subtotal.',
                ]);
            }

            $taxRate = (float) ($validated['tax_rate'] ?? 0);
            $taxAmount = round(max(0, ($subtotal - $discount) * ($taxRate / 100)), 2);

            $grandTotal = $subtotal - $discount + $taxAmount;

            $sale = Sale::create([
                'shop_id' => $shop->id,
                'user_id' => $user->id,
                'customer_id' => $validated['customer_id'] ?? null,

                'invoice_no' => $invoiceNumber,
                'invoice_date' => $validated['invoice_date'],

                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $taxAmount,
                'grand_total' => $grandTotal,

                'payment_method' => $validated['payment_method'],
                'status' => $validated['status'],
                'notes' => $validated['notes'] ?? null,
            ]);

            foreach ($validated['items'] as $item) {

                $quantity = (float) $item['quantity'];
                $rate = (float) $item['rate'];

                $sale->items()->create([
                    'item_name' => $item['item_name'],
                    'quantity' => $quantity,
                    'rate' => $rate,
                    'amount' => $quantity * $rate,
                ]);
            }
            // Compare using cents to avoid floating-point rounding issues
            $amountPaid = min((float) $validated['amount_paid'], (float) $sale->grand_total);

            $paidCents = (int) round($amountPaid * 100);
            $grandCents = (int) round((float) $sale->grand_total * 100);

            if ($paidCents > 0) {
                $sale->payments()->create([
                    'amount' => round($paidCents / 100, 2),
                    'payment_method' => $validated['payment_method'],
                    'paid_at' => now(),
                ]);
            }

            if ($paidCents < $grandCents) {
                $outstandingCents = $grandCents - $paidCents;
                $outstanding = round($outstandingCents / 100, 2);

                $paymentPlan = PaymentPlan::create([
                    'sale_id' => $sale->id,
                    'type' => 'mutual',
                    'down_payment' => round($paidCents / 100, 2),
                    'principal_amount' => $outstanding,
                    'total_payable' => $outstanding,
                    'installment_amount' => $outstanding,
                    'installment_count' => 1,
                    'frequency' => 'custom',
                    'start_date' => now()->toDateString(),
                    'status' => 'active',
                ]);

                $paymentPlan->installments()->create([
                    'due_date' => now()->toDateString(),
                    'amount' => $outstanding,
                    'paid_amount' => 0,
                    'status' => 'pending',
                ]);
            }

            return $sale;
        });

        $this->logActivity(
            $sale->status === 'draft' ? 'sale_draft_created' : 'sale_created',
            $sale->status === 'draft'
                ? "Invoice {$sale->invoice_no} was saved as a draft."
                : "Invoice {$sale->invoice_no} was completed successfully.",
        );

        if ($sale->status === 'draft') {
            return redirect()
                ->route('sales.index')
                ->with('success', 'Sale saved as draft.');
        }

        return redirect()
            ->route('sales.show', $sale)
            ->with('success', 'Sale created successfully.');
    }

    public function show(Sale $sale)
    {
        $this->authorizeSaleAccess($sale);

        $sale->load([
            'shop.settings',
            'customer',
            'items',
            'user',
            'payments',
        ]);

        return view('sales.show', compact('sale'));
    }

    public function print(Sale $sale)
    {
        $this->authorizeSaleAccess($sale);

        $sale->load(['customer', 'items', 'user']);

        return view('sales.print', compact('sale'));
    }

    public function cancel(Sale $sale)
    {
        $this->authorizeSaleAccess($sale);

        $sale->update(['status' => 'cancelled']);

        $this->logActivity(
            'sale_cancelled',
            "Invoice {$sale->invoice_no} was cancelled."
        );

        return redirect()->back()->with('success', 'Sale cancelled successfully.');
    }

    public function refund(Sale $sale)
    {
        $this->authorizeSaleAccess($sale);

        $sale->update(['status' => 'refunded']);

        $this->logActivity(
            'sale_refunded',
            "Invoice {$sale->invoice_no} was refunded."
        );

        return redirect()->back()->with('success', 'Sale refunded successfully.');
    }

    protected function authorizeSaleAccess(Sale $sale): void
    {
        $user = Auth::user();

        if ($user?->shop_id !== $sale->shop_id) {
            abort(404);
        }
    }
    public function bulkDelete(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'sale_ids' => ['required', 'array', 'min:1'],
            'sale_ids.*' => ['integer'],
        ]);

        $sales = Sale::where('shop_id', $user->shop_id)
            ->whereIn('id', $validated['sale_ids'])
            ->get();

        foreach ($sales as $sale) {
            $this->logActivity(
                'sale_deleted',
                "Invoice {$sale->invoice_no} was deleted."
            );
        }

        $sales->each->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Selected sales deleted successfully.');
    }
    protected function logActivity(
        string $action,
        string $description,
        ?int $userId = null,
        ?int $shopId = null
    ): void {
        $user = Auth::user();

        ActivityLog::create([
            'shop_id' => $shopId ?? $user->shop_id,
            'user_id' => $userId ?? $user->id,
            'action' => $action,
            'description' => $description,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }
}
