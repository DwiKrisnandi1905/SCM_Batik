<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use Illuminate\Http\Request;
use App\Models\Factory;
use App\Models\Harvest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Monitoring;
use Illuminate\Support\Facades\DB;
use App\Models\NFT;

class FactoryController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'harvest_id' => 'required|integer',
            'received_date' => 'required|date',
            'initial_process' => 'required|string|max:255',
            'semi_finished_quantity' => 'required|integer',
            'semi_finished_quality' => 'required|string|max:255',
            'factory_name' => 'required|string|max:255',
            'factory_address' => 'required|string|max:255',
        ]);

        $factory = new Factory($validated);
        $factory->user_id = auth()->id();

        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $factory->image = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

         $tokenURI = url('public/images/' . $imageName); 
        $fromAddress = NFT::first()->fromAddress;
        
        if ($fromAddress) {
            $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);
        }

         $factory->nft_token_id = $transactionHash;

        $factory->is_ref = 0;
        $factory->save();

        $url = route('factory.show', $factory->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeFactory.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $factory->qrcode = $qrCodeName;

        if ($factory->save()) {
            $harvest = Harvest::find($validated['harvest_id']);
            $harvest->is_ref = 1;
            $harvest->save();

            $monitoring = Monitoring::where('harvest_id', $factory->harvest_id)->first();
            if ($monitoring) {
                $monitoring->factory_id = $factory->id;
                $monitoring->status = 'In factory';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
                $factory->monitoring_id = $monitoring->id; // Add monitoring_id to factory data
                $factory->save();
            } else {
                $monitoring = new Monitoring();
                $monitoring->factory_id = $factory->id;
                $monitoring->status = 'In factory';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->harvest_id = $factory->harvest_id;
                $monitoring->save();
                $factory->monitoring_id = $monitoring->id; // Add monitoring_id to factory data
                $factory->save();
            }

            return redirect()->route('factory.index')->with('success', 'Factory created successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to create factory');
        }
    }

    public function index()
    {
        $userId = auth()->id();
        $query = "SELECT role_id FROM role_user WHERE user_id = $userId";
        $result = DB::select(DB::raw($query));
        if (!isset($result[0])) {
            return redirect()->route('roles.select');
        }

        $role = $result[0]->role_id;

        if ($role == 1) {
            $factory = Factory::all();
        } else {
            $factory = Factory::where('user_id', $userId)->get();
        }

        return view('factory.index', compact('factory'))->with([
            'name' => 'factory',
            'title' => 'factory'
        ]);
    }

    public function create()
    {
        $harvests = Harvest::all();
        return view('factory.create', compact('harvests'))->with([
            'title' => 'Factory',
            'name' => 'Factory'
        ]);
    }

    public function update(Request $request, $id)
    {
        $factory = Factory::findOrFail($id);

        $validated = $request->validate([
            'received_date' => 'sometimes|required|date',
            'initial_process' => 'sometimes|required|string',
            'semi_finished_quantity' => 'sometimes|required|numeric',
            'semi_finished_quality' => 'sometimes|required|string',
            'factory_name' => 'sometimes|required|string|max:255',
            'factory_address' => 'sometimes|required|string|max:255',
        ]);

        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;

            $oldImagePath = 'public/images/' . $factory->image;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }

        $url = route('factory.show', $factory->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeFactory.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $factory->qrcode = $qrCodeName;

        if ($factory->update($validated)) {
            return redirect()->route('factory.index')->with('success', 'Factory updated successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to update factory');
        }
    }

    public function show($id)
    {
        $factory = Factory::findOrFail($id);
        return view('factory.show', compact('factory'));
    }

    public function edit($id)
    {
        $harvests = Harvest::all();
        $factory = Factory::findOrFail($id);
        return view('factory.edit', compact('factory', 'harvests'))->with([
            'title' => 'Factory',
            'name' => 'Factory'
        ]);
    }

    public function destroy($id)
    {
        $factory = Factory::findOrFail($id);

        // Set the related monitoring records to null
        Monitoring::where('factory_id', $factory->id)->update(['factory_id' => null]);

        // Delete the associated image
        $imagePath = 'public/images/' . $factory->image;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        // Delete the associated QR code
        $qrCodePath = 'public/qrcodes/' . $factory->qrcode;
        if (Storage::exists($qrCodePath)) {
            Storage::delete($qrCodePath);
        }

        if ($factory->delete()) {
            return redirect()->route('factory.index')->with('success', 'Factory deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete factory');
        }
    }

}
