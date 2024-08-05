<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;
use Illuminate\Support\Facades\DB;

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
        
        $query = "INSERT INTO harvests (material_type, quantity, quality, delivery_info, delivery_date, image, user_id) 
              VALUES (?, ?, ?, ?, ?, ?, ?)";
        
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
        $query = "DELETE FROM harvests WHERE id = ?";
        $success = DB::delete($query, [$id]);

        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }

}
