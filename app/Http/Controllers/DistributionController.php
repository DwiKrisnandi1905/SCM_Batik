<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Distribution;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::all();
        return view('distributions.index', compact('distributions'));
    }

    public function create()
    {
        return view('distributions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            
        ]);

        Distribution::create($request->all());

        return redirect()->route('distributions.index')
            ->with('success', 'Distribution created successfully.');
    }

    public function show(Distribution $distribution)
    {
        return view('distributions.show', compact('distribution'));
    }

    public function edit(Distribution $distribution)
    {
        return view('distributions.edit', compact('distribution'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $request->validate([
            // Add validation rules for your distribution fields here
        ]);

        $distribution->update($request->all());

        return redirect()->route('distributions.index')
            ->with('success', 'Distribution updated successfully.');
    }

    public function destroy(Distribution $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')
            ->with('success', 'Distribution deleted successfully.');
    }
}
