<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use App\Models\WasteManagement;
use Illuminate\Http\Request;
use App\Models\Craftsman;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Monitoring;

class WasteManagementController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function index()
    {
        $wasteManagements = WasteManagement::all();
        return view('waste-management.index', compact('wasteManagements'));
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('waste-management.create', compact('craftsmen'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
            'craftsman_id' => 'required|integer|exists:craftsmen,id',
        ]);

        $validated['user_id'] = auth()->id(); // or auth()->user()->id
        $validated['is_ref'] = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        }

        $wasteManagement = WasteManagement::create($validated);

        // $tokenURI = url('public/images/' . $imageName); 
        // $fromAddress = '0x82494581249EeE88c97C949eEC16226789677f42'; 
        // $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);

        // $wasteManagement->nft_token_id = $transactionHash;

        // $wasteManagement->save();

        $url = route('waste-management.show', $wasteManagement->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeWasteManagement.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $wasteManagement->qrcode = $qrCodeName;

        if ($wasteManagement->save()) {
            $craftsman = Craftsman::find($validated['craftsman_id']);
            $craftsman->is_ref = 1;
            $craftsman->save();

            $monitoring = Monitoring::where('craftsman_id', $wasteManagement->craftsman_id)->first();
            if ($monitoring) {
                $monitoring->waste_id = $wasteManagement->id;
                $monitoring->status = 'In waste management';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
            } else {
                $monitoring = new Monitoring();
                $monitoring->waste_id = $wasteManagement->id;
                $monitoring->status = 'In waste management';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
            }

            return redirect()->route('waste.index')->with('success', 'Waste Management record created successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to create Waste Management record.');
        }
    }


    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $waste = WasteManagement::findOrFail($id);
        return view('waste-management.edit', compact('waste', 'craftsmen'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'waste_type' => 'required|string',
            'management_method' => 'required|string',
            'management_results' => 'required|string',
        ]);
        $validatedData['user_id'] = auth()->user()->id;
        $wasteManagement = WasteManagement::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($wasteManagement->image) {
                Storage::delete('public/images/' . $wasteManagement->image);
            }
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validatedData['image'] = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        $url = route('waste-management.show', $wasteManagement->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeWasteManagement.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $wasteManagement->qrcode = $qrCodeName;

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
        $image = $wasteManagement->image;
        $success = $wasteManagement->delete();
        if ($success) {
            if ($image && $image !== 'default') {
                Storage::delete('public/images/' . $image);
            }
            return redirect()->route('waste.index')->with('success', 'Waste Management record deleted successfully.');
        } else {
            return redirect()->route('waste.index')->with('error', 'Failed to delete Waste Management record.');
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
