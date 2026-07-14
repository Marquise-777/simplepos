<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SetupController extends Controller
{
    public function business(): View
    {
        return view('setup.business');
    }

    public function storeBusiness(Request $request)
    {
        $validated = $request->validate([
            'business_name' => ['required', 'string', 'max:150'],
            'owner_name'    => ['required', 'string', 'max:100'],
            'phone'         => ['nullable', 'string', 'max:30'],
            'email'         => ['nullable', 'email', 'max:150'],
            'address'       => ['nullable', 'string'],
            'city'          => ['nullable', 'string', 'max:100'],
            'state'         => ['nullable', 'string', 'max:100'],
            'country'       => ['nullable', 'string', 'max:100'],
        ]);

        $shop = Auth::user()->shop;

        $shop->update([
            'name'       => $validated['business_name'],
            'owner_name' => $validated['owner_name'],
            'phone'      => $validated['phone'],
            'email'      => $validated['email'],
            'address'    => $validated['address'],
            'city'       => $validated['city'],
            'state'      => $validated['state'],
            'country'    => $validated['country'],
        ]);

        return redirect()->route('setup.invoice');
    }
    public function invoice()
    {
        return view('setup.invoice');
    }

    public function storeInvoice(Request $request)
    {
        $validated = $request->validate([
            'invoice_prefix'   => ['required', 'string', 'max:20'],
            'invoice_template' => ['required', 'in:classic,modern,thermal58,thermal80,a4'],
            'paper_size'       => ['required', 'in:thermal58,thermal80,a4'],
            'currency'         => ['required', 'string', 'max:10'],
            'timezone'         => ['required', 'string', 'max:100'],
            'footer_text'      => ['nullable', 'string'],
            'primary_color'    => ['required', 'string', 'max:20'],
        ]);

        $setting = Auth::user()->shop->settings;

        $setting->update([
            'invoice_prefix'   => $validated['invoice_prefix'],
            'invoice_template' => $validated['invoice_template'],
            'paper_size'       => $validated['paper_size'],
            'currency'         => $validated['currency'],
            'timezone'         => $validated['timezone'],
            'footer_text'      => $validated['footer_text'],
            'primary_color'    => $validated['primary_color'],
        ]);

        Auth::user()->shop->update([
            'is_setup_completed' => true,
        ]);


        return redirect()->route('setup.complete');
    }

    public function complete()
    {
        return view('setup.complete');
    }


    public function finish()
    {
        $shop = Auth::user()->shop;

        // Final safety check
        if (! $shop->is_setup_complete) {
            $shop->update([
                'is_setup_complete' => true,
            ]);
        }

        return redirect()
            ->route('dashboard')
            ->with('success', '🎉 Welcome to SIMPOS! Your business is ready.');
    }
}
