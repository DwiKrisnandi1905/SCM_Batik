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
    NFT,
    Factory,
    CraftsmanFactory
};

class FactoryController extends Controller
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
        $factories = Factory::all();
        return view('factory.index', compact('factories'))->with([
            'name' => 'factory',
            'title' => 'Factory'
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $factory = new Factory($validated);
        $factory->user_id = auth()->id();

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $factory->image = $imageName;
        } 

        $tokenURI = url('storage/images/' . $imageName);
        $fromAddress = NFT::first()->fromAddress;

        if ($fromAddress) {
            $transactionHash = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
            $factory->nft_token_id = $transactionHash;
        }

        $factory->is_ref = 0;
        $factory->save();

        $factory->qrcode = $this->imageService->generateQrCode($factory->id);
        $factory->save();

        $harvest = Harvest::find($validated['harvest_id']);
        if ($harvest) {
            $harvest->is_ref = 1;
            $harvest->save();
        }

        $monitoring = Monitoring::where('harvest_id', $factory->harvest_id)->first();
        if ($monitoring) {
            $monitoring->last_updated = now();
            $monitoring->save();
        } else {
            $monitoring = new Monitoring([
                'last_updated' => now(),
                'harvest_id' => $factory->harvest_id,
            ]);
            $monitoring->save();
        }

        $factory->monitoring_id = $monitoring->id;
        $factory->save();

        CraftsmanFactory::create([
            'factory_id' => $factory->id, 
        ]);

        return redirect()->route('factory.index')->with('success', 'Factory created successfully');
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $this->imageService->deleteImage($factory->image);
            $validated['image'] = $imageName;
        }

        $url = route('factory.show', $factory->id);
        $qrCodeName = $this->imageService->generateQrCode($url);
        $validated['qrcode'] = $qrCodeName;
        $factory->update($validated);

        return redirect()->route('factory.index')->with('success', 'Factory updated successfully.');
    }

    public function show($id)
    {
        $factory = Factory::findOrFail($id);
        return view('factory.show', compact('factory'));
    }

    public function destroy($id)
    {
        $factory = Factory::findOrFail($id);

        $this->imageService->deleteImage($factory->image);
        $this->imageService->deleteImage($factory->qrcode, 'public/qrcodes');

        if ($factory->delete()) {
            return redirect()->route('factory.index')->with('success', 'Factory deleted successfully');
        } else {
            return redirect()->back()->with('error', 'Failed to delete factory');
        }
    }

}
