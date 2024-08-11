<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Craftsman;
use App\Models\Factory;
use Illuminate\Support\Facades\Storage;

class CraftsmanController extends Controller
{
    public function index()
    {
        $craftsmen = Craftsman::where('user_id', auth()->user()->id)->get();
        return view('craftsman.index', compact('craftsmen'));
    }

    public function create()
    {
        $factories = Factory::all();
        return view('craftsman.create', compact('factories'));
    }

    public function show(Craftsman $craftsman)
    {
        return view('craftsman.show', compact('craftsman'));
    }

    public function edit($id)
    {
        $factories = Factory::all();
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.edit', compact('factories', 'craftsman'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['user_id'] = auth()->id();
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }
        $validated['is_ref'] = 0;
        $craftsman = new Craftsman($validated);
        if ($craftsman->save()) {
            $factory = Factory::find($validated['factory_id']);
            $factory->is_ref = 1;
            $factory->save();
            return redirect()->route('craftsman.index')->with('success', 'Craftsman created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create craftsman.');
        }
    }
    
    public function update(Request $request, $id)
    {
        $craftsman = Craftsman::findOrFail($id);
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $validated['user_id'] = auth()->id();
    
        if ($request->hasFile('image')) {
            if ($craftsman->image) {
                Storage::delete('public/images/' . $craftsman->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        }
    
        $validated['is_ref'] = $craftsman->is_ref ?? 0;

        if ($craftsman->update($validated)) {
            $factory = Factory::find($validated['factory_id']);
            $factory->is_ref = 1;
            $factory->save();
            return redirect()->route('craftsman.index')->with('success', 'Craftsman updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update craftsman.');
        }
    }
    
    public function destroy($id)
    {
        $craftsman = Craftsman::findOrFail($id);
        $image = $craftsman->image;
        if ($image) {
            Storage::delete('public/images/' . $image);
        }
        $success = $craftsman->delete();

        if ($success) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete craftsman.');
        }
    }
}
