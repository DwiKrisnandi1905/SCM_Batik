<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DistributionMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $userId = $user->id;
        $roleIds = [1, 7]; 

        $query = "SELECT * FROM role_user WHERE user_id = $userId AND role_id IN (" . implode(',', $roleIds) . ")";
        $result = DB::select(DB::raw($query));

        if ($result) {
            return $next($request);
        }

        return redirect()->route('unauthorized');
    }
}
