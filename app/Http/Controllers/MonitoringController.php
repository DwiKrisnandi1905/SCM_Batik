<?php
namespace App\Http\Controllers;

use App\Models\Monitoring;
use Illuminate\Http\Request;

class MonitoringController extends Controller
{
    public function show($id)
    {
        $monitoring = Monitoring::with(['harvest', 'factory', 'craftsman', 'certification', 'WasteManagement', 'distribution'])->find($id);
    
        if ($monitoring) {
            return view('monitor', compact('monitoring'));
        } else {
            return view('monitor', ['fail' => 'Monitoring record not found.']);
        }
    }
}