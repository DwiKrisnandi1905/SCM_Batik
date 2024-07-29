<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Certification;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::all();
        return view('certifications.index', compact('certifications'));
    }

    public function create()
    {
        return view('certifications.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            // Define your validation rules here
        ]);

        Certification::create($validatedData);

        return redirect()->route('certifications.index')
            ->with('success', 'Certification record created successfully.');
    }

    public function show(Certification $certification)
    {
        return view('certifications.show', compact('certification'));
    }

    public function edit(Certification $certification)
    {
        return view('certifications.edit', compact('certification'));
    }

    public function update(Request $request, Certification $certification)
    {
        $validatedData = $request->validate([
            // Define your validation rules here
        ]);

        $certification->update($validatedData);

        return redirect()->route('certifications.index')
            ->with('success', 'Certification record updated successfully.');
    }

    public function destroy(Certification $certification)
    {
        $certification->delete();

        return redirect()->route('certifications.index')
            ->with('success', 'Certification record deleted successfully.');
    }
}
