<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CertificationMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('Certification')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
