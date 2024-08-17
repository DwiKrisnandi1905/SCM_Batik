<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function profileIndex()
    {
        $user = Auth::user();

        $users = DB::table('users')
            ->select('users.id AS user_id', 'users.name AS user_name', 'users.email AS user_email', 'users.image AS image', 'roles.id AS role_id', 'roles.name AS role_name')
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

    public function profileUpdate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        $user = auth()->user();
    
        // Using the User model's update method
        $user->name = $validated['name'];
        $user->email = $validated['email'];
    
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
    
            // Delete old image if it exists
            if ($user->image) {
                $oldImagePath = 'public/images/' . $user->image;
                if (Storage::exists($oldImagePath)) {
                    Storage::delete($oldImagePath);
                }
            }
    
            // Update user image path
            $user->image = $imageName;
        }
    
        if ($user->save()) {
            return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
        } else {
            return redirect()->route('profile.index')->with('error', 'Failed to update profile.');
        }
    }
    
    

    
}
