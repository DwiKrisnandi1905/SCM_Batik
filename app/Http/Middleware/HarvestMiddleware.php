<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HarvestMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole(3)) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
