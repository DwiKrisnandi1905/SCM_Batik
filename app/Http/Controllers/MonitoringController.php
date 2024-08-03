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
            return redirect()->route('monitorings.index')->with('success', 'Monitoring record created successfully.');
        } else {
            return redirect()->route('monitorings.index')->with('fail', 'Failed to create monitoring record.');
        }
    }

    public function show($id)
    {
        $monitoring = Monitoring::find($id);
        return view('monitorings.show', compact('monitoring'));
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
        return redirect()->route('monitorings.index')->with('success', 'Monitoring record updated successfully.');
    }

    public function destroy($id)
    {
        $monitoring = Monitoring::find($id);
        $monitoring->delete();
        return redirect()->route('monitorings.index')->with('success', 'Monitoring record deleted successfully.');
    }
}