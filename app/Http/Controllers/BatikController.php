<?php

namespace App\Http\Controllers;
use App\Models\{
    CraftsmanFactory,
    Monitoring,
    Factory
};

class BatikController extends Controller
{

    public function show($id)
    {
        $monitoring = Monitoring::with(['harvest', 'craftsman', 'certification', 'WasteManagement', 'distribution'])->find($id);

        if ($monitoring) {

            if ($monitoring->craftsman) {
                $craftsmanFactories = CraftsmanFactory::where('craftsman_id', $monitoring->craftsman->id)
                    ->join('factories', 'craftsman_factory.factory_id', '=', 'factories.id')
                    ->select('craftsman_factory.*', 'factories.factory_name', 'factories.factory_address', 'factories.image', 'factories.qrcode')
                    ->get();
            } else {
                $craftsmanFactories = Factory::where('harvest_id', $monitoring->harvest->id)->get();
            }

            return view('monitor_show', compact('monitoring', 'craftsmanFactories'))->with(['title' => 'Monitor', 'name' => 'Monitor']);
        } else {
            return view('monitor_show', ['fail' => 'Monitoring record not found.', 'title' => 'Monitor', 'name' => 'Monitor']);
        }
    }
    }

