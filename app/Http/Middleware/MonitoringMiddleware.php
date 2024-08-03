<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class MonitoringMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('Monitoring')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
