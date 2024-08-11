<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $material_type = $request->input('material_type');
        $quantity = $request->input('quantity');
        $quality = $request->input('quality');
        $delivery_info = $request->input('delivery_info');
        $delivery_date = $request->input('delivery_date');
        $image = $request->file('image');
        
        $userId = auth()->id();
        
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
        } else {
            $imageName = null;
        }
        
        $query = "INSERT INTO harvests (material_type, quantity, quality, delivery_info, delivery_date, image, user_id ,is_ref) 
              VALUES (?, ?, ?, ?, ?, ?, ? , 0)";
        
        $success = DB::insert($query, [$material_type, $quantity, $quality, $delivery_info, $delivery_date, $imageName, $userId]);
        
        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest created successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to create harvest.');
        }
    }

    public function show($id)
    {
        $harvest = DB::selectOne("SELECT * FROM harvests WHERE id = ?", [$id]);
        return view('harvests.show', compact('harvest'));
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

            // Delete the old image from storage
            $harvest = Harvest::findOrFail($id);
            $oldImagePath = 'public/images/' . $harvest->image;
            if (Storage::exists($oldImagePath)) {
            Storage::delete($oldImagePath);
            }
        }

        $query = "UPDATE harvests SET ";
        $params = [];
        foreach ($validated as $key => $value) {
            $query .= "$key = ?, ";
            $params[] = $value;
        }
        $query = rtrim($query, ', ');
        $query .= " WHERE id = ?";
        $params[] = $id;

        $success = DB::update($query, $params);

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
        $imagePath = 'public/images/' . $harvest->image;
    
        // Delete the image from storage
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    
        $query = "DELETE FROM harvests WHERE id = ?";
        $success = DB::delete($query, [$id]);
    
        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }
    

}
