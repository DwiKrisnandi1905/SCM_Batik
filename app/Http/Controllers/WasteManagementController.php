<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Services\{
    NFTService,
    ImageService
};

use App\Models\{
    Monitoring,
    NFT,
    Craftsman,
    WasteManagement
};

class WasteManagementController extends Controller
{
    protected $nftService;
    protected $imageService;
    public function __construct(NFTService $nftService, ImageService $imageService)
    {
        $this->nftService = $nftService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $user = auth()->user();
        $role = $user->roles()->firstOrFail();

        $wasteManagements = $role->id == 1
            ? WasteManagement::all()
            : WasteManagement::where('user_id', $user->id)->get();

        return view('waste-management.index', compact('wasteManagements'))->with([
            'name' => 'waste management',
            'title' => 'Waste Management'
        ]);
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('waste-management.create', compact('craftsmen'))->with([
            'title' => 'Waste Management',
            'name' => 'Waste Management'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
            'craftsman_id' => 'required|exists:craftsmen,id',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_ref'] = 0;

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $validated['image'] = $imageName;
        }

        $wasteManagement = WasteManagement::create($validated);

        if (isset($imageName)) {
            $tokenURI = url('storage/images/' . $imageName);
            $fromAddress = NFT::first()->fromAddress;

            if ($fromAddress) {
                $transactionHash = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
                $wasteManagement->nft_token_id = $transactionHash;
            }
        }

        $wasteManagement->save();

        $qrCodeName = $this->imageService->generateQrCode($wasteManagement->id);
        $wasteManagement->qrcode = $qrCodeName;
        $wasteManagement->save();

        $craftsman = Craftsman::find($validated['craftsman_id']);
        $craftsman->is_ref = 1;
        $craftsman->save();

        $monitoring = Monitoring::where('craftsman_id', $wasteManagement->craftsman_id)->first();
        if ($monitoring) {
            $monitoring->waste_id = $wasteManagement->id;
            $monitoring->last_updated = now();
            $monitoring->save();
            $wasteManagement->monitoring_id = $monitoring->id;
        } else {
            $monitoring = new Monitoring([
                'waste_id' => $wasteManagement->id,
                'last_updated' => now(),
                'craftsman_id' => $wasteManagement->craftsman_id,
            ]);
            $monitoring->save();
            $wasteManagement->monitoring_id = $monitoring->id;
        }

        $wasteManagement->save(); // Save the monitoring_id

        return redirect()->route('waste.index')->with('success', 'Waste Management record created successfully.');
    }

    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $waste = WasteManagement::findOrFail($id);
        return view('waste-management.edit', compact('waste', 'craftsmen'))->with([
            'title' => 'Waste Management',
            'name' => 'Waste Management'
        ]);
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096', // Optional image validation
        ]);
        $validatedData['user_id'] = auth()->user()->id;

        $wasteManagement = WasteManagement::findOrFail($id);
        if ($request->hasFile('image')) {
            $this->imageService->deleteImage($wasteManagement->image);
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $validatedData['image'] = $imageName;
        }

        $url = route('waste-management.show', $wasteManagement->id);
        $qrCodeName = $this->imageService->generateQrCode($url);

        $validatedData['qrcode'] = $qrCodeName;

        if ($wasteManagement->update($validatedData)) {
            return redirect()->route('waste.index')->with('success', 'Waste Management record updated successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to update Waste Management record.');
        }
    }

    public function show($id)
    {
        $wasteManagement = WasteManagement::findOrFail($id);
        return view('waste-management.show', compact('wasteManagement'));
    }

    public function destroy($id)
    {
        $wasteManagement = WasteManagement::findOrFail($id);
        Monitoring::where('waste_id', $wasteManagement->id)->update(['waste_id' => null]);

        $this->imageService->deleteImage($wasteManagement->image);
        $this->imageService->deleteImage($wasteManagement->qrcode, 'public/qrcodes');

        if ($wasteManagement->delete()) {
            return redirect()->route('waste.index')->with('success', 'Waste Management record deleted successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to delete Waste Management record.');
        }
    }

}
