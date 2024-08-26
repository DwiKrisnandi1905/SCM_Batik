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
    Distribution
};

class DistributionController extends Controller
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
    
        $distribution = $role->id == 1 
            ? Distribution::all() 
            : Distribution::where('user_id', $user->id)->get();
    
        return view('distribution.index', compact('distribution'))->with([
            'name' => 'distribution',
            'title' => 'Distribution'
        ]);
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('distribution.create', compact('craftsmen'))->with([
            'title' => 'Distribution',
            'name' => 'Distribution'
        ]);
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;

        $request->validate([
            'craftsman_id' => 'required|exists:craftsmen,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'shipment_date' => 'required|date',
            'tracking_number' => 'required|string|max:255',
            'received_date' => 'required|date',
            'receiver_name' => 'required|string|max:255',
            'received_condition' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $validatedData = $request->except('image');
        $validatedData['user_id'] = $userId;
        $validatedData['is_ref'] = 0;

        if ($request->hasFile('image')) {
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $validatedData['image'] = $imageName;
        }

        $distribution = Distribution::create($validatedData);

        if (isset($imageName)) {
            $tokenURI = url('storage/images/' . $imageName);
            $fromAddress = NFT::first()->fromAddress;

            if ($fromAddress) {
                $transactionHash = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
                $distribution->nft_token_id = $transactionHash;
            }
        }

        $qrCodeName = $this->imageService->generateQrCode($distribution->id);
        $distribution->qrcode = $qrCodeName;

        $distribution->save();

        $craftsman = Craftsman::find($request->input('craftsman_id'));
        if ($craftsman) {
            $craftsman->is_ref = 1;
            $craftsman->save();
        }

        $monitoring = Monitoring::where('craftsman_id', $distribution->craftsman_id)->first();
        if ($monitoring) {
            $monitoring->distribution_id = $distribution->id;
            $monitoring->last_updated = now();
            $monitoring->save();
            $distribution->monitoring_id = $monitoring->id;
        } else {
            $monitoring = new Monitoring([
                'distribution_id' => $distribution->id,
                'last_updated' => now(),
                'craftsman_id' => $distribution->craftsman_id,
            ]);
            $monitoring->save();
            $distribution->monitoring_id = $monitoring->id;
        }

        $distribution->save();

        return redirect()->route('distribution.index')->with('success', 'Distribution record created successfully.');
    }

    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $distribution = Distribution::find($id);
        return view('distribution.edit', compact('distribution', 'craftsmen'))->with([
            'title' => 'Distribution',
            'name' => 'Distribution'
        ]);
    }

    public function update(Request $request, $id)
    {
        $distribution = Distribution::find($id);
        if (!$distribution) {
            return redirect()->back()->with('error', 'Distribution record not found.');
        }

        $validatedData = $request->validate([
            'craftsman_id' => 'required|exists:craftsmen,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'shipment_date' => 'required|date',
            'tracking_number' => 'required|string|max:255',
            'received_date' => 'required|date',
            'receiver_name' => 'required|string|max:255',
            'received_condition' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $validatedData['user_id'] = auth()->id();

        if ($request->hasFile('image')) {
            $this->imageService->deleteImage($distribution->image);
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $validatedData['image'] = $imageName;
        }

        $url = route('distribution.show', $distribution->id);
        $qrCodeName = $this->imageService->generateQrCode($url);
        $validatedData['qrcode'] = $qrCodeName;
        $distribution->update($validatedData);

        return redirect()->route('distribution.index')->with('success', 'Distribution record updated successfully.');
    }

    public function show($id)
    {
        $distribution = Distribution::findOrFail($id);
        return view('distribution.show', compact('distribution'));
    }

    public function destroy($id)
    {
        $distribution = Distribution::find($id);
        Monitoring::where('distribution_id', $distribution->id)->update(['distribution_id' => null]);

        $this->imageService->deleteImage($distribution->image);
        $this->imageService->deleteImage($distribution->qrcode, 'public/qrcodes');

        if ($distribution->delete()) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete distribution record.');
        }
    }

}