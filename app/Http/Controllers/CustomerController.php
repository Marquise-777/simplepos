<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Support\Facades\Auth;

use Illuminate\Http\Request;

class CustomerController extends Controller
{


    public function index(Request $request)
    {
        $user = Auth::user();

        $search = $request->search;

        $customers = Customer::where('shop_id', $user->shop_id)
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('customers.index', compact('customers', 'search'));
    }

    public function create(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'max:100'],
            'phone' => ['nullable', 'max:30'],
            'email' => ['nullable', 'email', 'max:150'],
            'address' => ['nullable'],
            'notes' => ['nullable'],
        ]);

        $customer = Customer::create([
            ...$validated,
            'shop_id' => auth()->user()->shop_id,
        ]);

        return redirect()
            ->route('sales.index', ['customer_id' => $customer->id])
            ->with('success', 'Customer created successfully.');
    }
}
