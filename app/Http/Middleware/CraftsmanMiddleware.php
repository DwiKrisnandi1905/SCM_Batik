<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CraftsmanMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('Craftsman')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
