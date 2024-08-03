<?php
namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::all();
        return view('certification.index', compact('certifications'));
    }

    public function create()
    {
        return view('certification.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'test_results' => 'required|string',
            'certificate_number' => 'required|string',
            'issue_date' => 'required|date',
        ]);

        Certification::create($request->all());
        return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
    }

    public function show()
    {
        return view('certification.show', compact('certification'));
    }

    public function edit()
    {
        return view('certification.edit', compact('certification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'user_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'test_results' => 'required|string',
            'certificate_number' => 'required|string',
            'issue_date' => 'required|date',
        ]);

        $certification = Certification::findOrFail($id);
        $certification->update($request->all());
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();
        return redirect()->route('certification.index')->with('success', 'Certification deleted successfully.');
    }

}