<?php
namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '_' . $image->getClientOriginalName();
            $image->storeAs('public/images', $imageName);
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        $query = "INSERT INTO certifications (user_id, craftsman_id, test_results, certificate_number, issue_date, created_at, updated_at) VALUES (?, ?, ?, ?, ?, NOW(), NOW())";
        $bindings = [
            $user_id,
            $request->craftsman_id,
            $request->test_results,
            $request->certificate_number,
            $request->issue_date,
        ];

        if (DB::insert($query, $bindings)) {
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