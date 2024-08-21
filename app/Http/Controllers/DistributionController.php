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
use Illuminate\Support\Facades\DB;
use App\Models\NFT;

class DistributionController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function index()
    {
        $userId = auth()->user()->id;
        $query = "SELECT role_id FROM role_user WHERE user_id = $userId";
        $result = DB::select(DB::raw($query));
        if (!isset($result[0])) {
            return redirect()->route('roles.select');
        }

        $role = $result[0]->role_id;

        if ($role == 1) {
            $distribution = Distribution::all();
        } else {
            $distribution = Distribution::where('user_id', $userId)->get();
        }
        return view('distribution.index', compact('distribution'))->with([
            'name' => 'distribution',
            'title' => 'distribution'
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

        $tokenURI = url('public/images/' . $imageName);
        $fromAddress = NFT::first()->fromAddress;

        if ($fromAddress) {
            $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);
        }

        $distribution->nft_token_id = $transactionHash;

        $distribution->save(); // Save to get the ID

        // Generate and save QR code
        $url = route('distribution.show', $distribution->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);
        $qrCodeName = time() . '_qrcodeDistribution.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $distribution->qrcode = $qrCodeName;

        // Save QR code
        $distribution->save();

        // Update or create monitoring record
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
            $distribution->monitoring_id = $monitoring->id;
        } else {
            $monitoring = new Monitoring();
            $monitoring->distribution_id = $distribution->id;
            $monitoring->status = 'In distribution';
            $monitoring->last_updated = now();
            $monitoring->is_ref = 0;
            $monitoring->save();
            $distribution->monitoring_id = $monitoring->id;
        }

        // Save the monitoring_id
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

        // Set the related monitoring records to null
        Monitoring::where('distribution_id', $distribution->id)->update(['distribution_id' => null]);

        // Delete the associated image
        $imagePath = 'public/images/' . $distribution->image;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        // Delete the associated QR code
        $qrCodePath = 'public/qrcodes/' . $distribution->qrcode;
        if (Storage::exists($qrCodePath)) {
            Storage::delete($qrCodePath);
        }

        $success = $distribution->delete();

        if ($success) {
            return redirect()->route('distribution.index')->with('success', 'Distribution record deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete distribution record.');
        }
    }

}