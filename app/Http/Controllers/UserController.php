<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function profileIndex()
    {
        $user = Auth::user();

        $users = DB::table('users')
            ->select('users.id AS user_id', 'users.name AS user_name', 'users.email AS user_email', 'roles.id AS role_id', 'roles.name AS role_name')
            ->join('role_user', 'users.id', '=', 'role_user.user_id')
            ->join('roles', 'role_user.role_id', '=', 'roles.id')
            ->where('users.id', $user->id)
            ->get();

        return view('users.index', ['users' => $users]);
        
    }

    public function monitoringIndex()
    {
        return view('harvests.monitoring.index', [
            'name' => 'monitoring',
            'title' => 'monitoring',
        ]);
    }
}
