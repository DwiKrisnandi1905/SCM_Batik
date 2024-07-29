<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Harvest;

class HarvestController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'material_type' => 'required|string',
            'quantity' => 'required|numeric',
            'quality' => 'required|string',
            'delivery_info' => 'required|string',
            'delivery_date' => 'required|date',
        ]);

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
}
