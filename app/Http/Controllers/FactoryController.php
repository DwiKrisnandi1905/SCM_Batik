<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Harvest;
use Illuminate\Support\Facades\Storage;


class FactoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'harvest_id' => 'required|integer',
            'received_date' => 'required|date',
            'initial_process' => 'required|string|max:255',
            'semi_finished_quantity' => 'required|integer',
            'semi_finished_quality' => 'required|string|max:255',
            'factory_name' => 'required|string|max:255',
            'factory_address' => 'required|string|max:255',
        ]);
    
        $factory = new Factory($validated);
        $factory->user_id = auth()->id();
    
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $factory->image = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }
    
        $factory->is_ref = 0;
        if ($factory->save()) {
            $harvest = Harvest::find($validated['harvest_id']);
            $harvest->is_ref = 1;
            $harvest->save();
    
            return redirect()->route('factory.index')->with('success', 'Factory created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create factory');
        }
    }
    
    public function index()
    {
        $userId = auth()->id();
        $factory = Factory::where('user_id', $userId)->get();
        return view('factory.index', compact('factory'));
    }

    public function create()
    {
        $harvests = Harvest::all();
        return view('factory.create', compact('harvests'));
    }

    public function update(Request $request, $id)
    {
        $factory = Factory::findOrFail($id);
    
        $validated = $request->validate([
            'received_date' => 'sometimes|required|date',
            'initial_process' => 'sometimes|required|string',
            'semi_finished_quantity' => 'sometimes|required|numeric',
            'semi_finished_quality' => 'sometimes|required|string',
            'factory_name' => 'sometimes|required|string|max:255',
            'factory_address' => 'sometimes|required|string|max:255',
        ]);
    
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
    
            $oldImagePath = 'public/images/' . $factory->image;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }
    
        if ($factory->update($validated)) {
            return redirect()->route('factory.index')->with('success', 'Factory updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update factory');
        }
    }
    
    public function edit($id)
    {
        $harvests = Harvest::all();
        $factory = Factory::findOrFail($id);
        return view('factory.edit', compact('factory', 'harvests'));
    }

    public function destroy($id)
    {
        $factory = Factory::findOrFail($id);
        $imageName = $factory->image;
        if ($factory->delete()) {
            Storage::delete('public/images/' . $imageName);
            return redirect()->route('factory.index')->with('success', 'Factory deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete factory');
        }
    }
}
