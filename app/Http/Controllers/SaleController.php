<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoiceSequence;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $query = Sale::with(['customer', 'user', 'saleItems'])
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

            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' .
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

            $sale = Sale::create([
                'shop_id' => $shop->id,
                'user_id' => $user->id,
                'customer_id' => $validated['customer_id'] ?? null,

                'invoice_no' => $invoiceNumber,
                'invoice_date' => $validated['invoice_date'],

                'subtotal' => $subtotal,
                'discount' => 0,
                'tax' => 0,
                'grand_total' => $subtotal,

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

            return $sale;
        });

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

        $sale->load(['customer', 'items', 'user']);

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

        return redirect()->back()->with('success', 'Sale cancelled successfully.');
    }

    public function refund(Sale $sale)
    {
        $this->authorizeSaleAccess($sale);

        $sale->update(['status' => 'refunded']);

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

        Sale::where('shop_id', $user->shop_id)
            ->whereIn('id', $validated['sale_ids'])
            ->delete();

        return redirect()
            ->route('sales.index')
            ->with('success', 'Selected sales deleted successfully.');
    }
}
