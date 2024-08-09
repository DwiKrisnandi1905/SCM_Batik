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

        public function profileEdit()
        {
            $user = Auth::user();

            return view('users.edit', compact('user'));
        }

        public function profileUpdate()
        {
            $user = Auth::user();

            $data = request()->validate([
                'name' => 'required',
                'email' => 'required|email',
            ]);

            if ($user instanceof \Illuminate\Database\Eloquent\Model && $user->exists) {
                $user->update($data);
                return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
            }
            else {
                return redirect()->route('profile.index')->with('fail', 'Failed to update profile.');
            }
        }

}
