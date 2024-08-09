<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Craftsman;
use App\Models\Factory;
use Illuminate\Support\Facades\DB;

class CraftsmanController extends Controller
{
    public function index()
    {
        $craftsmen = Craftsman::where('user_id', auth()->user()->id)->get();
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
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $validated['user_id'] = auth()->user()->id;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        $query = "INSERT INTO craftsmen (user_id, factory_id, production_details, finished_quantity, completion_date, image) VALUES (?, ?, ?, ?, ?, ?)";
        $params = [
            $validated['user_id'],
            $validated['factory_id'],
            $validated['production_details'],
            $validated['finished_quantity'],
            $validated['completion_date'],
            $imageName
        ];

        $success = DB::insert($query, $params);

        if ($success) {
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

        if ($request->hasFile('image')) {
            // Delete old image
            $oldImage = $craftsman->image;
            if ($oldImage) {
            Storage::delete('public/images/' . $oldImage);
            }

            // Save new image
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);

            $validated['image'] = $imageName;
        }

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
        $image = $craftsman->image;
        if ($image) {
            Storage::delete('public/images/' . $image);
        }
        $success = $craftsman->delete();

        if ($success) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete craftsman.');
        }
    }
}
