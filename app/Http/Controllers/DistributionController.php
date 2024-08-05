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

        $query = "INSERT INTO distributions (user_id, craftsman_id, destination, quantity, shipment_date, tracking_number, received_date, receiver_name, received_condition) 
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $values = [
            $userId,
            $request->input('craftsman_id'),
            $request->input('destination'),
            $request->input('quantity'),
            $request->input('shipment_date'),
            $request->input('tracking_number'),
            $request->input('received_date'),
            $request->input('receiver_name'),
            $request->input('received_condition')
        ];

        $result = DB::insert($query, $values);

        if ($result) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create distribution record.');
        }
    }

    public function show($id)
    {
        $distribution = Distribution::find($id);
        return view('distribution.show', compact('distribution'));
    }

    public function edit($id)
    {
        $distribution = Distribution::find($id);
        return view('distribution.edit', compact('distribution'));
    }

    public function update(Request $request, Distribution $distribution)
    {
        $query = "UPDATE distributions SET user_id = ?, craftsman_id = ?, destination = ?, quantity = ?, shipment_date = ?, tracking_number = ?, received_date = ?, receiver_name = ?, received_condition = ? WHERE id = ?";

        $values = [
            $request->input('user_id'),
            $request->input('craftsman_id'),
            $request->input('destination'),
            $request->input('quantity'),
            $request->input('shipment_date'),
            $request->input('tracking_number'),
            $request->input('received_date'),
            $request->input('receiver_name'),
            $request->input('received_condition'),
            $distribution->id
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