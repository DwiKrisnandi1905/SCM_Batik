<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Harvest;

class FactoryController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();
        $validated = $request->validate([
            'harvest_id' => 'required|integer|exists:harvests,id',
            'received_date' => 'required|date_format:Y-m-d\TH:i', 
            'initial_process' => 'required|string',
            'semi_finished_quantity' => 'required|numeric',
            'semi_finished_quality' => 'required|string',
            'factory_name' => 'required|string',
            'factory_address' => 'required|string',
        ]);

        $validated['user_id'] = $userId; 
        $factory = Factory::create($validated);

        if ($factory) {
            return response()->json(['success' => true, 'message' => 'Factory created successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to create factory']);
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

    public function show($id)
    {
        $factory = Factory::findOrFail($id);
        return response()->json($factory);
    }

    public function update(Request $request, $id)
    {
        $factory = Factory::findOrFail($id);
        $validated = $request->validate([
            'received_date' => 'sometimes|required|date',
            'initial_process' => 'sometimes|required|string',
            'semi_finished_quantity' => 'sometimes|required|numeric',
            'semi_finished_quality' => 'sometimes|required|string',
        ]);

        if ($factory->update($validated)) {
            return response()->json(['success' => true, 'message' => 'Factory updated successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to update factory']);
        }
    }

    public function edit($id)
    {
        $factory = Factory::findOrFail($id);
        return view('factory.edit', compact('factory'));
    }

    public function destroy($id)
    {
        $factory = Factory::findOrFail($id);
        if ($factory->delete()) {
            return response()->json(['success' => true, 'message' => 'Factory deleted successfully']);
        } else {
            return response()->json(['success' => false, 'message' => 'Failed to delete factory']);
        }
    }
}
