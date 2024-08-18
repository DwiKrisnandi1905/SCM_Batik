<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use Illuminate\Http\Request;
use App\Models\Craftsman;
use App\Models\Factory;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Monitoring;

class CraftsmanController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function index()
    {
        $craftsmen = Craftsman::where('user_id', auth()->user()->id)->get();
        return view('craftsman.index', compact('craftsmen'));
    }

    public function create()
    {
        $factories = Factory::all();
        return view('craftsman.create', compact('factories'));
    }

    public function edit($id)
    {
        $factories = Factory::all();
        $craftsman = Craftsman::findOrFail($id);
        return view('craftsman.edit', compact('factories', 'craftsman'));
    }
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);
        $validated['user_id'] = auth()->id();
        $image = $request->file('image');
        if ($image) {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        } else {
            return response()->json(['success' => false, 'message' => 'Image upload failed']);
        }

        $validated['is_ref'] = 0;
        $craftsman = new Craftsman($validated);
        // $tokenURI = url('public/images/' . $imageName); 
        // $fromAddress = '0xae36F58eb2579b5A48547C1FB505080cA91b5D7F'; 
        // $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);

        // $craftsman->nft_token_id = $transactionHash;
        $craftsman->save();

        $url = route('craftsman.show', $craftsman->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeCraftsman.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $craftsman->qrcode = $qrCodeName;

        if ($craftsman->save()) {
            $factory = Factory::find($validated['factory_id']);
            $factory->is_ref = 1;
            $factory->save();

            $monitoring = Monitoring::where('factory_id', $craftsman->factory_id)->first();
            if ($monitoring) {
                $monitoring->craftsman_id = $craftsman->id;
                $monitoring->status = 'In craftsman';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
                $craftsman->monitoring_id = $monitoring->id; // Add monitoring_id to craftsman data
                $craftsman->save();
            } else {
                $monitoring = new Monitoring();
                $monitoring->craftsman_id = $craftsman->id;
                $monitoring->status = 'In craftsman';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
                $craftsman->monitoring_id = $monitoring->id; // Add monitoring_id to craftsman data
                $craftsman->save();
            }
            return redirect()->route('craftsman.index')->with('success', 'Craftsman created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create craftsman.');
        }
    }
    
    public function update(Request $request, $id)
    {
        $craftsman = Craftsman::findOrFail($id);
        $validated = $request->validate([
            'factory_id' => 'required|integer|exists:factories,id',
            'production_details' => 'required|string',
            'finished_quantity' => 'required|numeric',
            'completion_date' => 'required|date_format:Y-m-d\TH:i',
        ]);

        $validated['user_id'] = auth()->id();
    
        if ($request->hasFile('image')) {
            if ($craftsman->image) {
                Storage::delete('public/images/' . $craftsman->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $validated['image'] = $imageName;
        }
    
        $validated['is_ref'] = $craftsman->is_ref ?? 0;

        $url = route('craftsman.show', $craftsman->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeCraftsman.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $craftsman->qrcode = $qrCodeName;

        if ($craftsman->update($validated)) {
            $factory = Factory::find($validated['factory_id']);
            $factory->is_ref = 1;
            $factory->save();
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
        $image = $craftsman->image;
        if ($image) {
            Storage::delete('public/images/' . $image);
        }
        $success = $craftsman->delete();

        if ($success) {
            return redirect()->route('craftsman.index')->with('success', 'Craftsman deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete craftsman.');
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
