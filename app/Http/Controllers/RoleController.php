<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function select()
    {
        $roles = Role::all();
        return view('roles.select', compact('roles'));
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $validated = $request->validate([
            'role_id' => 'required|integer|between:1,255',
        ]);        
        $validated['user_id'] = $user_id;
        $role = RoleUser::create($validated);
        if ($role) {
            return response()->json($role, 201);
        } else {
            return response()->json(['message' => 'Failed to create role'], 500);
        }
    }
    
}
