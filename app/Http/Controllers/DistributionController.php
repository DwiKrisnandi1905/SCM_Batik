<?php
namespace App\Http\Controllers;

use App\Models\Distribution;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function index()
    {
        $distribution = Distribution::all();
        return view('distribution.index', compact('distribution'));
    }

    public function create()
    {
        return view('distribution.create');
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        // Store the image file in public/images directory
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);
        } else {
            $imageName = null;
        }

        $query = "INSERT INTO distributions (user_id, craftsman_id, destination, quantity, shipment_date, tracking_number, received_date, receiver_name, received_condition, image_name) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $values = [
            $userId,
            $request->input('craftsman_id'),
            $request->input('destination'),
            $request->input('quantity'),
            $request->input('shipment_date'),
            $request->input('tracking_number'),
            $request->input('received_date'),
            $request->input('receiver_name'),
            $request->input('received_condition'),
            $imageName
        ];

        $result = DB::insert($query, $values);

        if ($result) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create distribution record.');
        }
    }

    public function edit($id)
    {
        $distribution = Distribution::find($id);
        return view('distribution.edit', compact('distribution'));
    }

    public function update(Request $request,$id)
    {
        if ($request->hasFile('image')) {
            // Delete the old image if it exists
            $oldImageName = $distribution->image_name;
            if ($oldImageName) {
                $oldImagePath = public_path('images') . '/' . $oldImageName;
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath);
                }
            }

            // Store the new image file in public/images directory
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('images'), $imageName);

            // Update the image name in the database
            $distribution->image_name = $imageName;
        } else {
            $imageName = $distribution->image_name;
        }

        $query = "UPDATE distributions SET craftsman_id = ?, destination = ?, quantity = ?, shipment_date = ?, tracking_number = ?, received_date = ?, receiver_name = ?, received_condition = ?, image_name = ? WHERE id = ?";
        $values = [
            $request->input('craftsman_id'),
            $request->input('destination'),
            $request->input('quantity'),
            $request->input('shipment_date'),
            $request->input('tracking_number'),
            $request->input('received_date'),
            $request->input('receiver_name'),
            $request->input('received_condition'),
            $imageName,
            $id
        ];

        $result = DB::update($query, $values);

        if ($result) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update distribution record.');
        }
    }

    public function destroy($id)
    {
        $query = "DELETE FROM distributions WHERE id = ?";
        $values = [$id];

        $result = DB::delete($query, $values);

        if ($result) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete distribution record.');
        }
    }
}