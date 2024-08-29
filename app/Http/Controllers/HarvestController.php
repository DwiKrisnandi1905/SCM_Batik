<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Services\{
    NFTService,
    ImageService
};

use App\Models\{
    Harvest,
    Monitoring,
    NFT
};

class HarvestController extends Controller
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
        $harvests = Harvest::all();
        return view('harvests.index', compact('harvests'))->with([
            'name' => 'harvest',
            'title' => 'Harvest'
        ]);
    }

    public function create()
    {
        return view('harvests.create', ['title' => 'Harvest', 'name' => 'Harvest']);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_type' => 'required|string',
            'quantity' => 'required|numeric',
            'quality' => 'required|string',
            'delivery_info' => 'required|string',
            'delivery_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $harvest = new Harvest($validated);
        $harvest->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $harvest->image = $imageName;

            $tokenURI = url('storage/images/' . $imageName);
            $fromAddress = NFT::first()->fromAddress;

            if ($fromAddress) {
                $harvest->nft_token_id = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
            }
        }

        $harvest->is_ref = 0;
        $harvest->save();

        $harvest->qrcode = $this->imageService->generateQrCode($harvest->id);
        $harvest->save();

        $monitoring = new Monitoring([
            'harvest_id' => $harvest->id,
            'last_updated' => now(),
        ]);

        $monitoring->save();

        $harvest->monitoring_id = $monitoring->id;
        $harvest->save();
        return redirect()->route('harvest.index')->with('success', 'Harvest created successfully.');
    }

    public function show($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.show', compact('harvest'));
    }

    public function edit($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.edit', compact('harvest'))->with(['title' => 'Harvest', 'name' => 'Harvest']);
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'material_type' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|numeric',
            'quality' => 'sometimes|required|string',
            'delivery_info' => 'sometimes|required|string',
            'delivery_date' => 'sometimes|required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $harvest = Harvest::findOrFail($id);

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $this->imageService->deleteImage($harvest->image);
            $validated['image'] = $imageName;
        }

        $harvest->update($validated);

        $url = route('harvests.show', $harvest->id);
        $qrCodeName = $this->imageService->generateQrCode($url);

        $harvest->qrcode = $qrCodeName;
        $harvest->save();

        return redirect()->route('harvest.index')->with('success', 'Harvest updated successfully.');
    }

    public function destroy($id)
    {
        $harvest = Harvest::findOrFail($id);
        Monitoring::where('harvest_id', $harvest->id)->update(['harvest_id' => null]);

        $this->imageService->deleteImage($harvest->image);
        $this->imageService->deleteImage($harvest->qrcode, 'public/qrcodes');

        if ($harvest->delete()) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }

}
