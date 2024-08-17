<?php
namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'harvest_id' => 'required|integer',
            'factory_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'certification_id' => 'required|integer',
            'waste_id' => 'required|integer',
            'distribution_id' => 'required|integer',
            'status' => 'required|string',
            'last_updated' => 'required|date',
        ]);

        $monitoring = Monitoring::create($request->all());

        if ($monitoring) {
            return response()->json(['success' => 'Monitoring record created successfully.']);
        } else {
            return response()->json(['fail' => 'Failed to create monitoring record.']);
        }
    }

    public function show($id)
    {
        $monitoring = Monitoring::find($id);

        if ($monitoring) {
            $monitoring->load('harvest', 'factory', 'craftsman', 'certification', 'WasteManagement', 'distribution');
            return response()->json(compact('monitoring'));
        } else {
            return response()->json(['fail' => 'Monitoring record not found.']);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'harvest_id' => 'required|integer',
            'factory_id' => 'required|integer',
            'craftsman_id' => 'required|integer',
            'certification_id' => 'required|integer',
            'waste_id' => 'required|integer',
            'distribution_id' => 'required|integer',
            'status' => 'required|string',
            'last_updated' => 'required|date',
        ]);

        $monitoring = Monitoring::find($id);
        $monitoring->update($request->all());
        if ($monitoring) {
            return response()->json(['success' => 'Monitoring record updated successfully.']);
        } else {
            return response()->json(['fail' => 'Failed to update monitoring record.']);
        }
    }
}