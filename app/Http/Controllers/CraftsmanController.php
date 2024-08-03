<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Craftsman;
use App\Models\Factory;

class CraftsmanController extends Controller
{
    public function index()
    {
        $craftsmen = Craftsman::all();
        return view('craftsman.index', compact('craftsmen'));
    }

    public function create()
    {
        Factory::all();
        return view('craftsman.create');
    }

    public function show(Craftsman $craftsman)
    {
        return view('craftsman.show', compact('craftsman'));
    }

    public function edit($id)
    {
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.edit', compact('craftsman'));
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $validated['user_id'] = auth()->user()->id;

        $craftsman = Craftsman::create($validated);

        if ($craftsman) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create craftsman.');
        }
    }

    public function update(Request $request, $id)
    {
        $craftsman = Craftsman::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $success = $craftsman->update($validated);

        if ($success) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update craftsman.');
        }
    }

    public function destroy($id)
    {
        $craftsman = Craftsman::findOrFail($id);
        $success = $craftsman->delete();

        if ($success) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete craftsman.');
        }
    }
}
