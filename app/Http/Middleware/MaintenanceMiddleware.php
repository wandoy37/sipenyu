<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MaintenanceMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Logika untuk menentukan apakah aplikasi dalam mode perawatan
        if (app()->isDownForMaintenance()) {
            return redirect()->route('maintenance');
        }

        return $next($request);
    }
}
