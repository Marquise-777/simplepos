<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\Shop;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = null;

        DB::transaction(function () use ($request, &$user) {

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $shop = Shop::create([
                'name' => $user->name . "'s Shop",
                'slug' => Str::slug($user->name) . '-' . Str::random(5),
                'phone' => '0000000000',
                'owner_name' => $user->name,
                'email' => $user->email,
                'address' => 'Default Address',
                'city' => 'Default City',
                'state' => 'Default State',
                'country' => 'Default Country',
                'status' => 'active',
            ]);

            $user->update([
                'shop_id' => $shop->id,
                'role' => 'owner',
                'status' => 'active',
            ]);

            Setting::create([
                'shop_id' => $shop->id,

                'business_name' => $shop->name,
                'phone' => $shop->phone,
                'email' => $shop->email,
                'invoice_prefix' => 'INV-' . strtoupper(Str::random(3)),
                'date_format' => 'd-m-Y',
                'invoice_template' => 'classic',
                'gst' => 'Null',
                'paper_size' => 'a4',

                'currency' => 'INR',

                'timezone' => 'Asia/Kolkata',

                'primary_color' => '#3b82f6',
            ]);
        });

        event(new Registered($user));

        Auth::login($user);

        return redirect(route('setup.business'));
    }
}
