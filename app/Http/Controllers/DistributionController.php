<?php
namespace App\Http\Controllers;

use App\Services\NFTService;
use App\Models\Distribution;
use Illuminate\Http\Request;
use App\Models\Craftsman;
use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\Monitoring;

class DistributionController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function index()
    {
        $distribution = Distribution::all();
        return view('distribution.index', compact('distribution'));
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('distribution.create', compact('craftsmen'));
    }

    public function store(Request $request)
    {
        $userId = auth()->user()->id;
    
        // Validate request
        $request->validate([
            'craftsman_id' => 'required|exists:craftsmen,id',
            'destination' => 'required|string|max:255',
            'quantity' => 'required|integer',
            'shipment_date' => 'required|date',
            'tracking_number' => 'required|string|max:255',
            'received_date' => 'required|date',
            'receiver_name' => 'required|string|max:255',
            'received_condition' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);
    
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
        } else {
            return redirect()->back()->with('error', 'Image upload failed.');
        }
    
        // Create new distribution record
        $distribution = new Distribution();
        $distribution->user_id = $userId;
        $distribution->craftsman_id = $request->input('craftsman_id');
        $distribution->destination = $request->input('destination');
        $distribution->quantity = $request->input('quantity');
        $distribution->shipment_date = $request->input('shipment_date');
        $distribution->tracking_number = $request->input('tracking_number');
        $distribution->received_date = $request->input('received_date');
        $distribution->receiver_name = $request->input('receiver_name');
        $distribution->received_condition = $request->input('received_condition');
        $distribution->image = $imageName;
        $distribution->is_ref = 0;

        // $tokenURI = url('public/images/' . $imageName); 
        // $fromAddress = '0x82494581249EeE88c97C949eEC16226789677f42'; 
        // $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);

        // $distribution->nft_token_id = $transactionHash;

        $distribution->save();

        $url = route('distribution.show', $distribution->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeDistribution.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $distribution->qrcode = $qrCodeName;
    
        if ($distribution->save()) {
            // Update Craftsman record
            $craftsman = Craftsman::find($request->input('craftsman_id'));
            if ($craftsman) {
                $craftsman->is_ref = 1;
                $craftsman->save();
            }

            $monitoring = Monitoring::where('craftsman_id', $distribution->craftsman_id)->first();
            if ($monitoring) {
                $monitoring->distribution_id = $distribution->id;
                $monitoring->status = 'In distribution';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
            } else {
                $monitoring = new Monitoring();
                $monitoring->distribution_id = $distribution->id;
                $monitoring->status = 'In distribution';
                $monitoring->last_updated = now();
                $monitoring->is_ref = 0;
                $monitoring->save();
            }
    
            return redirect()->route('distribution.index')->with('success', 'Distribution record created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create distribution record.');
        }
    }
    
    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $distribution = Distribution::find($id);
        return view('distribution.edit', compact('distribution', 'craftsmen'));
    }

    public function update(Request $request, $id)
    {
        $distribution = Distribution::find($id);
        if (!$distribution) {
            return redirect()->back()->with('error', 'Distribution record not found.');
        }

        $oldImage = $distribution->image;
        if ($oldImage) {
            Storage::delete('public/images/' . $oldImage);
        }

        $distribution->craftsman_id = $request->input('craftsman_id');
        $distribution->destination = $request->input('destination');
        $distribution->quantity = $request->input('quantity');
        $distribution->shipment_date = $request->input('shipment_date');
        $distribution->tracking_number = $request->input('tracking_number');
        $distribution->received_date = $request->input('received_date');
        $distribution->receiver_name = $request->input('receiver_name');
        $distribution->received_condition = $request->input('received_condition');

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $distribution->image = $imageName;
        }

        $url = route('distribution.show', $distribution->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeDistribution.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $distribution->qrcode = $qrCodeName;

        if ($distribution->save()) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update distribution record.');
        }
    }

    public function show($id)
    {
        $distribution = Distribution::findOrFail($id);
        return view('distribution.show', compact('distribution'));
    }

    public function destroy($id)
    {
        $distribution = Distribution::find($id);
        $image = $distribution->image;
        if ($image) {
            Storage::delete('public/images/' . $image);
        }
        if ($distribution) {
            $distribution->delete();
            return redirect()->route('distribution.index')->with('success', 'Distribution record deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete distribution record.');
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