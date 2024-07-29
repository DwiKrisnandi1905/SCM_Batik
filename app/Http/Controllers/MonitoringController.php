<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Monitoring;

class MonitoringController extends Controller
{
    public function index()
    {
        $monitorings = Monitoring::all();
        return view('monitorings.index', compact('monitorings'));
    }

    public function create()
    {
        return view('monitorings.create');
    }

    public function store(Request $request)
    {
        $monitoring = new Monitoring();
        // Set the attributes of the monitoring model based on the request data
        $monitoring->attribute1 = $request->input('attribute1');
        $monitoring->attribute2 = $request->input('attribute2');
        // Set other attributes as needed
        $monitoring->save();

        return redirect()->route('monitorings.index')->with('success', 'Monitoring created successfully.');
    }

    public function show($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        return view('monitorings.show', compact('monitoring'));
    }

    public function edit($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        return view('monitorings.edit', compact('monitoring'));
    }

    public function update(Request $request, $id)
    {
        $monitoring = Monitoring::findOrFail($id);
        // Update the attributes of the monitoring model based on the request data
        $monitoring->attribute1 = $request->input('attribute1');
        $monitoring->attribute2 = $request->input('attribute2');
        // Update other attributes as needed
        $monitoring->save();

        return redirect()->route('monitorings.index')->with('success', 'Monitoring updated successfully.');
    }

    public function destroy($id)
    {
        $monitoring = Monitoring::findOrFail($id);
        $monitoring->delete();

        return redirect()->route('monitorings.index')->with('success', 'Monitoring deleted successfully.');
    }
}
