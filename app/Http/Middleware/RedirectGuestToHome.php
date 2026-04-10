<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * RedirectGuestToHome
 *
 * If a guest tries to access any admin route, redirect them to the
 * public landing page instead of the login page.
 */
class RedirectGuestToHome
{
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->user()) {
            return redirect()->route('admin.login');
        }

        return $next($request);
    }
}
