<?php
namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::where('user_id', auth()->id())->get();
        return view('certification.index', compact('certifications'));
    }

    public function create()
    {
        return view('certification.create');
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();

        $request->validate([
            'user_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'test_results' => 'required|string',
            'certificate_number' => 'required|string',
            'issue_date' => 'required|date',
        ]);

        $certification = Certification::create([
            'user_id' => $user_id,
            'craftsman_id' => $request->craftsman_id,
            'test_results' => $request->test_results,
            'certificate_number' => $request->certificate_number,
            'issue_date' => $request->issue_date,
        ]);

        if ($certification) {
            return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create certification.');
        }
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
        if ($certification->update($request->all())) {
            return redirect()->route('certification.index')->with('success', 'Certification updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update certification.');
        }
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $certification->delete();
        return redirect()->route('certification.index')->with('success', 'Certification deleted successfully.');
    }

}