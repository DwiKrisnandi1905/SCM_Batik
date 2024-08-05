<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Harvest;
use Illuminate\Support\Facades\DB;

class FactoryController extends Controller
{
    public function store(Request $request)
    {
        $userId = auth()->id();
        $query = "INSERT INTO factories (user_id, harvest_id, received_date, initial_process, semi_finished_quantity, semi_finished_quality, factory_name, factory_address) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $bindings = [
            $userId,
            $request->input('harvest_id'),
            $request->input('received_date'),
            $request->input('initial_process'),
            $request->input('semi_finished_quantity'),
            $request->input('semi_finished_quality'),
            $request->input('factory_name'),
            $request->input('factory_address')
        ];

        if (DB::insert($query, $bindings)) {
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
