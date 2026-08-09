<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\InvoiceSequence;
use App\Models\Sale;
use App\Models\SaleItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SaleController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $sales = Sale::with(['customer', 'user', 'saleItems'])
            ->where('shop_id', $user->shop_id)
            ->latest('invoice_date')
            ->paginate(15);

        $customers = Customer::where('shop_id', Auth::user()->shop_id)
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
            'payment_method' => ['nullable', 'in:cash,upi,bank,card,mixed'],
            'notes' => ['nullable', 'string'],
            'items' => ['nullable', 'array'],
            'items.*.item_name' => ['nullable', 'string'],
            'items.*.quantity' => ['nullable', 'numeric'],
            'items.*.rate' => ['nullable', 'numeric'],
        ]);

        $shop = $user?->shop;

        if (! $shop) {
            return redirect()->back()->withErrors(['shop' => 'No shop is linked to this account.']);
        }

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

        $sale = Sale::create([
            'shop_id' => $shop->id,
            'user_id' => $user->id,
            'customer_id' => $validated['customer_id'] ?? null,
            'invoice_no' => 'INV-' . now()->format('Ymd') . '-' . str_pad((string) $sequence->fresh()->current_number, 4, '0', STR_PAD_LEFT),
            'invoice_date' => now(),
            'subtotal' => 0,
            'discount' => 0,
            'tax' => 0,
            'grand_total' => 0,
            'payment_method' => $validated['payment_method'] ?? 'cash',
            'status' => 'completed',
            'notes' => $validated['notes'] ?? null,
        ]);

        $subtotal = 0;

        foreach ($validated['items'] ?? [] as $item) {
            $quantity = (float) ($item['quantity'] ?? 0);
            $rate = (float) ($item['rate'] ?? 0);
            $amount = $quantity * $rate;

            $subtotal += $amount;

            $sale->items()->create([
                'item_name' => $item['item_name'] ?? 'Item',
                'quantity' => $quantity,
                'rate' => $rate,
                'amount' => $amount,
            ]);
        }

        $sale->update([
            'subtotal' => $subtotal,
            'grand_total' => $subtotal,
        ]);

        return redirect()->route('sales.show', $sale)
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
}
