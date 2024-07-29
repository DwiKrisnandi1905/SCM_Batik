<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Craftsman;

class CraftsmanController extends Controller
{
    public function index()
    {
        $craftsmen = Craftsman::all();
        return view('craftsmen.index', compact('craftsmen'));
    }

    public function create()
    {
        return view('craftsmen.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // Add validation rules for other fields
        ]);

        Craftsman::create($request->all());

        return redirect()->route('craftsmen.index')
            ->with('success', 'Craftsman created successfully.');
    }

    public function show(Craftsman $craftsman)
    {
        return view('craftsmen.show', compact('craftsman'));
    }

    public function edit(Craftsman $craftsman)
    {
        return view('craftsmen.edit', compact('craftsman'));
    }

    public function update(Request $request, Craftsman $craftsman)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            // Add validation rules for other fields
        ]);

        $craftsman->update($request->all());

        return redirect()->route('craftsmen.index')
            ->with('success', 'Craftsman updated successfully.');
    }

    public function destroy(Craftsman $craftsman)
    {
        $craftsman->delete();

        return redirect()->route('craftsmen.index')
            ->with('success', 'Craftsman deleted successfully.');
    }
}
