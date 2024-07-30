<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return response()->json($roles);
    }

    public function select()
    {
        $roles = Role::all();
        return view('roles.select', compact('roles'));
    }

    public function show($id)
    {
        $role = Role::findOrFail($id);
        return response()->json($role);
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $validated = $request->validate([
            'role_id' => 'required|integer|between:1,255',
        ]);        
        $validated['user_id'] = $user_id;
        $role = RoleUser::create($validated);
        return response()->json($role, 201);
    }
    

    public function update(Request $request, $id)
    {
        $role = Role::findOrFail($id);
        $validated = $request->validate([
            'role_id' => 'required|integer|between:1,255',
        ]);

        $role->update($validated);
        return response()->json($role);
    }

    public function delete($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return response()->json(null, 204);
    }
}
