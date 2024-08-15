<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $userId = $user->id;

            $query = "SELECT role_id FROM role_user WHERE user_id = $userId";
            $result = DB::select(DB::raw($query));
            if (!isset($result[0])) {
                return redirect()->route('roles.select');
            }
            
            $role = $result[0]->role_id;            
            
            if ($role == 1) {
                auth()->user()->role = 'Admin';
                return redirect('/');
            } elseif ($role == 2) {
                auth()->user()->role = 'Harvester';
                return redirect()->route('harvest.index');
            } elseif ($role == 3) {
                auth()->user()->role = 'Factory';
                return redirect()->route('factory.index');
            } elseif ($role == 4) {
                auth()->user()->role = 'Craftsman';
                return redirect()->route('craftsman.index');
            } elseif ($role == 5) {
                auth()->user()->role = 'Certificator';
                return redirect()->route('certification.index');
            } elseif ($role == 6) {
                auth()->user()->role = 'Waste Manager';
                return redirect()->route('waste.index');
            } else {
                auth()->user()->role = 'Distributor';
                return redirect()->route('distribution.index');
            }
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        return redirect('/');
    }
}
