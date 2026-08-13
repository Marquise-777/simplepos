<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::firstOrCreate(
            ['shop_id' => auth()->user()->shop_id],
            [
                'business_name' => auth()->user()->shop->name ?? '',
                'currency' => '₹',
                'timezone' => 'Asia/Kolkata',
                'date_format' => 'd M Y',
                'invoice_template' => 'classic',
                'paper_size' => 'a4',
                'primary_color' => '#2563eb',
            ]
        );

        return view('settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $settings = Setting::where(
            'shop_id',
            auth()->user()->shop_id
        )->firstOrFail();

        $validated = $request->validate([
            'business_name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:30',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string',
            'gst' => 'nullable|string|max:100',
            'fssai' => 'nullable|string|max:100',

            'invoice_prefix' => 'required|string|max:20',
            'invoice_template' => 'required|in:classic,modern,thermal58,thermal80,a4',
            'paper_size' => 'required|in:thermal58,thermal80,a4',

            'currency' => 'required|string|max:10',
            'timezone' => 'required|string|max:100',
            'date_format' => 'required|string|max:30',

            'footer_text' => 'nullable|string',
            'primary_color' => 'required|string|max:20',

            'logo' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('logo')) {
            if ($settings->logo) {
                Storage::disk('public')->delete($settings->logo);
            }

            $validated['logo'] = $request->file('logo')
                ->store('settings', 'public');
        }

        $settings->update($validated);

        return back()->with('success', 'Settings updated successfully.');
    }
}
