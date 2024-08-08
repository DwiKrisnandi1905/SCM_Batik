<?php

namespace App\Http\Controllers;

use App\Models\Batik;
use Illuminate\Http\Request;

class BatikController extends Controller
{
    public function index()
    {
        $batiks = Batik::all();
        return view('batiks.index', compact('batiks'));
    }

    public function create()
    {
        return view('batiks.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'pattern' => 'required',
            'fabric_type' => 'required',
            'batik_type' => 'required',
        ]);

        Batik::create($validatedData);

        return redirect()->route('batiks.index')->with('success', 'Batik created successfully.');
    }

    public function show($id)
    {
        $batik = Batik::findOrFail($id);
        return view('batiks.show', compact('batik'));
    }

    public function edit($id)
    {
        $batik = Batik::findOrFail($id);
        return view('batiks.edit', compact('batik'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name' => 'required',
            'pattern' => 'required',
            'fabric_type' => 'required',
            'batik_type' => 'required',
        ]);

        $batik = Batik::findOrFail($id);
        $batik->update($validatedData);

        return redirect()->route('batiks.index')->with('success', 'Batik updated successfully.');
    }

    public function destroy($id)
    {
        $batik = Batik::findOrFail($id);
        $batik->delete();

        return redirect()->route('batiks.index')->with('success', 'Batik deleted successfully.');
    }
}
