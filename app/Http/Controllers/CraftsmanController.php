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
    Factory,
    Craftsman,
    CraftsmanFactory
};

class CraftsmanController extends Controller
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
        $craftsmen = $role->id == 1 ? Craftsman::all() : Craftsman::where('user_id', $user->id)->get();

        return view('craftsman.index', compact('craftsmen'))->with([
            'name' => 'craftsman',
            'title' => 'Craftsman'
        ]);
    }

    public function create()
    {
        $factories = Factory::all();
        return view('craftsman.create', compact('factories'))->with([
            'title' => 'Craftsman',
            'name' => 'Craftsman'
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:4096',
        ]);

        $validated['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $validated['image'] = $imageName;
        }

        $validated['is_ref'] = 0;
        $craftsman = new Craftsman($validated);

        $tokenURI = url('storage/images/' . $imageName);
        $fromAddress = NFT::first()->fromAddress;

        if ($fromAddress) {
            $transactionHash = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
            $craftsman->nft_token_id = $transactionHash;
        }

        $craftsman->save();

        $craftsman->qrcode = $this->imageService->generateQrCode($craftsman->id);
        $craftsman->save();

        $factory = Factory::find($validated['factory_id']);
        if ($factory) {
            $factory->is_ref = 1;
            $factory->save();
        }
        
        CraftsmanFactory::where('factory_id', $validated['factory_id'])
            ->update([
                'craftsman_id' => $craftsman->id,
            ]);
        
        $monitoring = Monitoring::where('harvest_id', $factory->harvest_id)->first();
        if ($monitoring) {
            $monitoring->craftsman_id = $craftsman->id;
            $monitoring->save();
        
            $craftsman->monitoring_id = $monitoring->id;
            $craftsman->save();
        }
        
        return redirect()->route('craftsman.index')->with('success', 'Craftsman created successfully.');
    }

    public function edit($id)
    {
        $factories = Factory::all();
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.edit', compact('factories', 'craftsman'))->with([
            'title' => 'Craftsman',
            'name' => 'Craftsman'
        ]);
    }

    public function update(Request $request, $id)
    {
        $craftsman = Craftsman::findOrFail($id);

        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['is_ref'] = $craftsman->is_ref ?? 0;
        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $this->imageService->deleteImage($craftsman->image);
            $validated['image'] = $imageName;
        }

        $url = route('craftsman.show', $craftsman->id);
        $qrCodeName = $this->imageService->generateQrCode($url);

        $validated['qrcode'] = $qrCodeName;

        if ($craftsman->update($validated)) {
            $factory = Factory::find($validated['factory_id']);
            if ($factory) {
                $factory->is_ref = 1;
                $factory->save();
            }

            return redirect()->route('craftsman.index')->with('success', 'Craftsman updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update craftsman.');
        }
    }

    public function show($id)
    {
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.show', compact('craftsman'));
    }

    public function destroy($id)
    {
        $craftsman = Craftsman::findOrFail($id);
        Monitoring::where('craftsman_id', $craftsman->id)->update(['craftsman_id' => null]);

        $this->imageService->deleteImage($craftsman->image);
        $this->imageService->deleteImage($craftsman->qrcode, 'public/qrcodes');

        if ($craftsman->delete()) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete craftsman.');
        }
    }

    public function createfacref($id){
        $factories = Factory::all();
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.facref', compact('factories', 'craftsman'))->with([
            'title' => 'Craftsman',
            'name' => 'Craftsman'
        ]);
    }

    public function storefacref(Request $request) {
        CraftsmanFactory::create([
            'factory_id' => $request->factory_id, 
            'craftsman_id' => $request->craftsman_id
        ]);

        return redirect()->route('craftsman.index')->with('success', 'Ref add successfully.');
    }    

}
