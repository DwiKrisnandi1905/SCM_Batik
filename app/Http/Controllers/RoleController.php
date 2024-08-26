<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function select()
    {
        $roles = Role::where('id', '!=', 1)->get();
        return view('roles.select', compact('roles'));
    }

    public function store(Request $request)
    {
        $user_id = auth()->user()->id;
        $validated = $request->validate([
            'role_id' => 'required|integer|between:1,7',
        ]);
        $validated['user_id'] = $user_id;

        $role = RoleUser::create($validated);

        if ($role) {
            $roles = [
                1 => ['name' => 'Admin', 'route' => '/'],
                2 => ['name' => 'Harvester', 'route' => 'harvest.index'],
                3 => ['name' => 'Factory', 'route' => 'factory.index'],
                4 => ['name' => 'Craftsman', 'route' => 'craftsman.index'],
                5 => ['name' => 'Certificator', 'route' => 'certification.index'],
                6 => ['name' => 'Waste Manager', 'route' => 'waste.index'],
                7 => ['name' => 'Distributor', 'route' => 'distribution.index'],
            ];
            auth()->user()->role = $roles[$validated['role_id']]['name'];

            return redirect()->route($roles[$validated['role_id']]['route']);
        } else {
            return redirect()->back()
                ->withInput($request->input())
                ->withErrors(['message' => 'Failed to create role']);
        }
    }


}
