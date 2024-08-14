<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use Illuminate\Http\Request;
use App\Models\Harvest;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;

class HarvestController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function store(Request $request)
    {
        $validated = $request->validate([
            'material_type' => 'required|string',
            'quantity' => 'required|numeric',
            'quality' => 'required|string',
            'delivery_info' => 'required|string',
            'delivery_date' => 'required|date',
        ]);

        $harvest = new Harvest($validated);
        $harvest->user_id = auth()->id();

        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $harvest->image = $imageName;
        }

        //  $tokenURI = url('public/images/' . $imageName); 
        //  $fromAddress = '0x82494581249EeE88c97C949eEC16226789677f42'; 
        //  $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);
 
        //  $harvest->nft_token_id = $transactionHash; 

        $harvest->is_ref = 0;
        $harvest->save();

        $url = route('harvests.show', $harvest->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcode.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $harvest->qrcode = $qrCodeName;

        if ($harvest->save()) {
            return redirect('/harvest')->with('success', 'Harvest created successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to create harvest.');
        }
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'material_type' => 'sometimes|required|string',
            'quantity' => 'sometimes|required|numeric',
            'quality' => 'sometimes|required|string',
            'delivery_info' => 'sometimes|required|string',
            'delivery_date' => 'sometimes|required|date',
        ]);

        $harvest = Harvest::findOrFail($id);

        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
            //asd
            $harvest = Harvest::findOrFail($id);
            $oldImagePath = 'public/images/' . $harvest->image;
            if (Storage::exists($oldImagePath)) {
                Storage::delete($oldImagePath);
            }
        }
        //asd
        $harvest = Harvest::findOrFail($id);
        $harvest->update($validated);

        $url = route('harvests.show', $harvest->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcode.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $harvest->qrcode = $qrCodeName;

        if ($harvest) {
            return redirect('/harvest')->with('success', 'Harvest updated successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to update harvest.');
        }
    }
    public function show($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.show', compact('harvest'));
    }

    public function index()
    {
        $userId = auth()->id();
        $harvests = Harvest::where('user_id', $userId)->get();
        return view('harvests.index', compact('harvests'));
    }

    public function create()
    {
        return view('harvests.create');
    }

    public function edit($id)
    {
        $harvest = Harvest::findOrFail($id);
        return view('harvests.edit', compact('harvest'));
    }

    public function destroy($id)
    {
        $harvest = Harvest::findOrFail($id);
        $imagePath = 'public/images/' . $harvest->image;

        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        $success = $harvest->delete();

        if ($success) {
            return redirect('/harvest')->with('success', 'Harvest deleted successfully.');
        } else {
            return redirect('/harvest')->with('error', 'Failed to delete harvest.');
        }
    }

    public function verifyNFT($transactionHash)
    {
        try {
            $transactionReceipt = $this->nftService->verifyNFT($transactionHash);

            if ($transactionReceipt) {
                return response()->json([
                    'success' => true,
                    'message' => 'NFT verification successful',
                    'data' => $transactionReceipt,
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Transaction not found',
                ]);
            }
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }
}
