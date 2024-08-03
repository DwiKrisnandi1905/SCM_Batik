<?php
namespace App\Http\Controllers;

use App\Models\Distribution;
use Illuminate\Http\Request;

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
        $request->validate([
            'craftsman_id' => 'required|integer',
            'destination' => 'required|string',
            'quantity' => 'required|numeric',
            'shipment_date' => 'required|date_format:Y-m-d\TH:i',
            'tracking_number' => 'required|string',
            'received_date' => 'required|date',
            'receiver_name' => 'required|string',
            'received_condition' => 'required|string',
        ]);

        $userId = auth()->user()->id;

        $distribution = Distribution::create(array_merge($request->all(), ['user_id' => $userId]));

        if ($distribution) {
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
        $request->validate([
            'user_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'destination' => 'required|string',
            'quantity' => 'required|numeric',
            'shipment_date' => 'required|date',
            'tracking_number' => 'required|string',
            'received_date' => 'required|date',
            'receiver_name' => 'required|string',
            'received_condition' => 'required|string',
        ]);

        $distribution->update($request->all());
        return redirect()->route('distribution.index')->with('success', 'Distribution record updated successfully.');
    }

    public function destroy($id)
    {
        Distribution::destroy($id);
        return redirect()->route('distribution.index')->with('success', 'Distribution record deleted successfully.');
    }
}