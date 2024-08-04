<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_type' => 'required|string',
            'quantity' => 'required|numeric',
            'quality' => 'required|string',
            'delivery_info' => 'required|string',
            'delivery_date' => 'required|date',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');
            $validated['image'] = $imagePath; 
        }

        $validated['user_id'] = auth()->id();
        $harvest = Harvest::create($validated);

        if ($harvest) {
            return redirect('/harvest')->with('success', 'Harvest created successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to create harvest.');
        }
    }

    public function show($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.show', compact('harvest'));
    }

    public function update(Request $request, $id)
    {
        $harvest = Harvest::findOrFail($id);
        $validated = $request->validate([
            'material_type' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|numeric',
            'quality' => 'sometimes|required|string',
            'delivery_info' => 'sometimes|required|string',
            'delivery_date' => 'sometimes|required|date',
        ]);

        $success = $harvest->update($validated);
        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest updated successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to update harvest.');
        }
    }

    public function index()
    {
        $userId = auth()->id();
        $harvests = Harvest::where('user_id', $userId)->get();
        return view('harvests.index', compact('harvests'));
    }

    public function create()
    {
        return view('harvests.create');
    }

    public function edit($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.edit', compact('harvest'));
    }

    public function destroy($id)
    {
        $harvest = Harvest::findOrFail($id);
        if ($harvest->delete()) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }

    // profile
    public function profileIndex()
    {
        return view('harvests.profile.index' ,[
            'name' => 'profile',
            'title' => 'profile',
        ]);
    }

    //monitoring
    public function monitoringIndex()
    {
        return view('harvests.monitoring.index' ,[
            'name' => 'monitoring',
            'title' => 'monitoring',
        ]);
    }
}
