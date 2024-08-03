<?php
namespace App\Http\Controllers;

use App\Models\WasteManagement;
use Illuminate\Http\Request;

class WasteManagementController extends Controller
{
    public function index()
    {
        $wasteManagements = WasteManagement::all();
        return view('waste-management.index', compact('wasteManagements'));
    }

    public function create()
    {
        return view('waste-management.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
        ]);

        $wasteManagement = WasteManagement::create($request->all());
        if ($wasteManagement) {
            return redirect()->route('waste-management.index')->with('success', 'Waste Management record created successfully.');
        } else {
            return redirect()->route('waste-management.index')->with('error', 'Failed to create Waste Management record.');
        }
    }

    public function show(WasteManagement $wasteManagement)
    {
        return view('waste-management.show', compact('wasteManagement'));
    }

    public function edit(WasteManagement $wasteManagement)
    {
        return view('waste-management.edit', compact('wasteManagement'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
        ]);

        $wasteManagement = WasteManagement::findOrFail($id);
        $wasteManagement->update($request->all());

        return redirect()->route('waste-management.index')->with('success', 'Waste Management record updated successfully.');
    }

    public function destroy($id)
    {
        $wasteManagement = WasteManagement::findOrFail($id);
        $wasteManagement->delete();

        return redirect()->route('waste-management.index')->with('success', 'Waste Management record deleted successfully.');
    }
}