<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class FactoryMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->roleuser('Factory')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
