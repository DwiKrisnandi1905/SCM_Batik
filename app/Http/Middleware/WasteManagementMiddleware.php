<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class WasteManagementMiddleware
{

    public function handle(Request $request, Closure $next)
    {
        if ($request->user()->hasRole('WasteManagement')) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
