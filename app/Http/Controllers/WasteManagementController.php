<?php
namespace App\Http\Controllers;

use App\Models\WasteManagement;
use Illuminate\Http\Request;
use App\Models\Craftsman;

class WasteManagementController extends Controller
{
    public function index()
    {
        $wasteManagements = WasteManagement::all();
        return view('waste-management.index', compact('wasteManagements'));
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('waste-management.create', compact('craftsmen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'craftsman_id' => 'required|integer',
        ]);

        $validated['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        $wasteManagement = WasteManagement::create($validated);

        if ($wasteManagement) {
            return redirect()->route('waste.index')->with('success', 'Waste Management record created successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to create Waste Management record.');
        }
    }

    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $waste = WasteManagement::findOrFail($id);
        return view('waste-management.edit', compact('waste', 'craftsmen'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $wasteManagement = WasteManagement::findOrFail($id);

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        if ($wasteManagement->update($validatedData)) {
            return redirect()->route('waste.index')->with('success', 'Waste Management record updated successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to update Waste Management record.');
        }
    }
    

    public function destroy($id)
    {
        $wasteManagement = WasteManagement::findOrFail($id);
        $image = $wasteManagement->image;
        
        if ($wasteManagement->delete()) {
            // Delete image file
            if ($image) {
            $imagePath = public_path('images') . '/' . $image;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            }
            
            return redirect()->route('waste.index')->with('success', 'Waste Management record deleted successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to delete Waste Management record.');
        }
    }
}