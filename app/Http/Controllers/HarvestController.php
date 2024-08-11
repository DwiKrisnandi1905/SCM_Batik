<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;
use Illuminate\Support\Facades\Storage;

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
        ]);
        
        $harvest = new Harvest($validated);
        $harvest->user_id = auth()->id();
        
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $harvest->image = $imageName;
        }
        
        $harvest->is_ref = 0;
        if ($harvest->save()) {
            return redirect('/harvest')->with('success', 'Harvest created successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to create harvest.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'material_type' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|numeric',
            'quality' => 'sometimes|required|string',
            'delivery_info' => 'sometimes|required|string',
            'delivery_date' => 'sometimes|required|date',
        ]);

        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
            $harvest = Harvest::findOrFail($id);
            $oldImagePath = 'public/images/' . $harvest->image;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }

        $harvest = Harvest::findOrFail($id);
        $harvest->update($validated);

        if ($harvest) {
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
        $imagePath = 'public/images/' . $harvest->image;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $success = $harvest->delete();

        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }

}
