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
    
        return response()->json($harvest, 201);
    }

    public function show($id)
    {
        $harvest = Harvest::findOrFail($id);
        return response()->json($harvest);
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

        $harvest->update($validated);
        return response()->json($harvest);
    }

    public function delete($id)
    {
        $harvest = Harvest::findOrFail($id);
        $harvest->delete();
        return response()->json(null, 204);
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

    public function showView($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.show', compact('harvest'));
    }

    public function destroy($id)
    {
        $harvest = Harvest::findOrFail($id);
        $harvest->delete();
        return response()->json(null, 204);
    }
    
}
