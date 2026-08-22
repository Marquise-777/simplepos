<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Support\AdminActivity;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::guard('admin')->attempt($credentials, $request->boolean('remember'))) {
            return back()
                ->withErrors([
                    'email' => 'Invalid administrator credentials.',
                ])
                ->withInput($request->only('email'));
        }

        $admin = Auth::guard('admin')->user();

        if ($admin->status !== 'active') {
            Auth::guard('admin')->logout();

            return back()
                ->withErrors([
                    'email' => 'This administrator account is inactive.',
                ])
                ->withInput($request->only('email'));
        }

        $request->session()->regenerate();

        $admin->update([
            'last_login_at' => now(),
        ]);

        AdminActivity::log(
            'admin.login',
            'Administrator logged into the admin panel.'
        );

        return redirect()->intended(
            route('admin.dashboard')
        );
    }

    public function logout(Request $request)
    {
        AdminActivity::log(
            'admin.logout',
            'Administrator logged out of the admin panel.'
        );

        Auth::guard('admin')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }
}
