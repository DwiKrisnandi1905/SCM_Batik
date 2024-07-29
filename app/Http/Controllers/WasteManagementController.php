<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\WasteManagement;

class WasteManagementController extends Controller
{
    public function index()
    {
        $wasteManagements = WasteManagement::all();
        return view('waste_management.index', compact('wasteManagements'));
    }

    public function create()
    {
        return view('waste_management.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Define your validation rules here
        ]);

        WasteManagement::create($validatedData);

        return redirect()->route('waste_management.index')
            ->with('success', 'Waste management record created successfully.');
    }

    public function show(WasteManagement $wasteManagement)
    {
        return view('waste_management.show', compact('wasteManagement'));
    }

    public function edit(WasteManagement $wasteManagement)
    {
        return view('waste_management.edit', compact('wasteManagement'));
    }

    public function update(Request $request, WasteManagement $wasteManagement)
    {
        $validatedData = $request->validate([
            // Define your validation rules here
        ]);

        $wasteManagement->update($validatedData);

        return redirect()->route('waste_management.index')
            ->with('success', 'Waste management record updated successfully.');
    }

    public function destroy(WasteManagement $wasteManagement)
    {
        $wasteManagement->delete();

        return redirect()->route('waste_management.index')
            ->with('success', 'Waste management record deleted successfully.');
    }
}
