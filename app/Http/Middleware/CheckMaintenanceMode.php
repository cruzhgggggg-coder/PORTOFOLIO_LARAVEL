<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Don't block if user is logged in (admin)
        if (\Illuminate\Support\Facades\Auth::check()) {
            return $next($request);
        }

        // Don't block admin login routes or logout
        if ($request->is('admin*') || $request->is('akses-rahasia-admin*') || $request->is('login') || $request->is('logout')) {
            return $next($request);
        }

        if (SiteSetting::isMaintenanceMode()) {
            return response()->view('errors.maintenance', [], 503);
        }

        return $next($request);
    }
}
