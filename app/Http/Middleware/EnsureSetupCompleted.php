<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureSetupCompleted
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Allow setup pages
        if ($request->routeIs('setup.*')) {
            return $next($request);
        }

        // Redirect if setup isn't complete
        if (!$user->shop?->is_setup_complete) {
            return redirect()->route('setup.business');
        }

        return $next($request);
    }
}
