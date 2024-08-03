<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class DistributionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('Distribution')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
