<?php
namespace App\Http\Controllers;

use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Craftsman;

class CertificationController extends Controller
{
    public function index()
    {
        $certifications = Certification::where('user_id', auth()->id())->get();
        return view('certification.index', compact('certifications'));
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('certification.create', compact('craftsmen'));
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();

        $query = "INSERT INTO certifications (user_id, craftsman_id, test_results, certificate_number, issue_date, image, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, NOW(), NOW())";
        $bindings = [
            $user_id,
            $request->craftsman_id,
            $request->test_results,
            $request->certificate_number,
            $request->issue_date,
            'default',
        ];

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $bindings[5] = $image_name;
        }

        if (DB::insert($query, $bindings)) {
            return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create certification.');
        }
    }

    public function edit($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certification.edit', compact('certification'));
    }

    public function update(Request $request, $id)
    {
        $user_id = auth()->id();

        $query = "UPDATE certifications SET user_id = ?, craftsman_id = ?, test_results = ?, certificate_number = ?, issue_date = ?, image = ?, updated_at = NOW() WHERE id = ?";
        $bindings = [
            $user_id,
            $request->craftsman_id,
            $request->test_results,
            $request->certificate_number,
            $request->issue_date,
            'default',
            $id,
        ];

        if ($request->hasFile('image')) {
            $oldImage = Certification::findOrFail($id)->image;
            if ($oldImage != 'default') {
            $imagePath = public_path('images') . '/' . $oldImage;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
            }

            $image = $request->file('image');
            $image_name = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $image_name);
            $bindings[5] = $image_name;
        }

        if (DB::update($query, $bindings)) {
            return redirect()->route('certification.index')->with('success', 'Certification updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update certification.');
        }
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);
        $image = $certification->image;
        if ($image != 'default') {
            $imagePath = public_path('images') . '/' . $image;
            if (file_exists($imagePath)) {
            unlink($imagePath);
            }
        }
        $certification->delete();
        return redirect()->route('certification.index')->with('success', 'Certification deleted successfully.');
    }

}