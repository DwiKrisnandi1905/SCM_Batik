<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Factory;

class FactoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'harvest_id' => 'required|integer|exists:harvests,id',
            'received_date' => 'required|date',
            'initial_process' => 'required|string',
            'semi_finished_quantity' => 'required|numeric',
            'semi_finished_quality' => 'required|string',
        ]);

        $factory = Factory::create($validated);
        return response()->json($factory, 201);
    }

    public function index()
    {
        $userId = auth()->id();
        $harvests = Factory::where('user_id', $userId)->get();
        return view('factory.index', compact('harvests'));
    }

    public function create()
    {
        return view('factory.create');
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

        $factory->update($validated);
        return response()->json($factory);
    }

    public function delete($id)
    {
        $factory = Factory::findOrFail($id);
        $factory->delete();
        return response()->json(null, 204);
    }
}
