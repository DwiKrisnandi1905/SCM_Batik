<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
    
        $userId = $user->id;
        $roleId = 1; 
    
        $query = "SELECT * FROM role_user WHERE user_id = $userId AND role_id = $roleId";
        $result = DB::select(DB::raw($query));
    
        if ($result) {
            return $next($request);
        }
    
        return redirect()->route('unauthorized');
    }
    
}
