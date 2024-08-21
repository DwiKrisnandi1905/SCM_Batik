<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Craftsman;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use App\Models\NFT;

use Barryvdh\DomPDF\Facade\Pdf;

use App\Models\Monitoring;

class CertificationController extends Controller
{

    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
    }
    public function index()
    {
        $certifications = Certification::where('user_id', auth()->id())->get();
        return view('certification.index', compact('certifications'))->with([
            'name' => 'certification',
            'title' => 'certification'
        ]);
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('certification.create', compact('craftsmen'))->with([
            'title' => 'Certification',
            'name' => 'Certification'
        ]);
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();
        $validated = $request->validate([
            'craftsman_id' => 'required|integer|exists:craftsmen,id',
            'batik_type' => 'required|string|max:255',
            'test_results' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is validated
        ]);

        $certification = new Certification();
        $certification->user_id = $user_id;
        $certification->craftsman_id = $validated['craftsman_id'];
        $certification->batik_type = $validated['batik_type'];
        $certification->test_results = $validated['test_results'];
        $certification->certificate_number = $validated['certificate_number'];
        $certification->issue_date = $validated['issue_date'];
        $certification->is_ref = 0;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $certification->image = $imageName;
        }

        $tokenURI = url('public/images/' . $imageName); 
        $fromAddress = NFT::first()->fromAddress;
        
        if ($fromAddress) {
            $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);
        }

        $certification->nft_token_id = $transactionHash;

        $certification->save();

        $url = route('certification.show', $certification->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeCertification.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $certification->qrcode = $qrCodeName;

        $Craftsman = Craftsman::find($validated['craftsman_id']);
        $Craftsman->is_ref = 1;
        $Craftsman->save();

        $monitoring = Monitoring::where('craftsman_id', $certification->craftsman_id)->first();
        if ($monitoring) {
            $monitoring->certification_id = $certification->id;
            $monitoring->status = 'Certified';
            $monitoring->last_updated = now();
            $monitoring->is_ref = 0;
            $monitoring->save();
            $certification->monitoring_id = $monitoring->id;
        } else {
            $monitoring = new Monitoring();
            $monitoring->certification_id = $certification->id;
            $monitoring->status = 'Certified';
            $monitoring->last_updated = now();
            $monitoring->is_ref = 0;
            $monitoring->save();
            $certification->monitoring_id = $monitoring->id;
        }

        $certification->save();

        return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
    }


    public function edit($id)
    {
        $craftsmen = Craftsman::all();
        $certification = Certification::findOrFail($id);
        return view('certification.edit', compact('craftsmen', 'certification'))->with([
            'title' => 'Waste Management',
            'name' => 'Waste Management'
        ]);
    }

    public function update(Request $request, $id)
    {
        $user_id = auth()->id();
        $certification = Certification::findOrFail($id);
        $certification->user_id = $user_id;
        $certification->craftsman_id = $request->craftsman_id;
        $certification->batik_type = $request->batik_type;
        $certification->test_results = $request->test_results;
        $certification->certificate_number = $request->certificate_number;
        $certification->issue_date = $request->issue_date;

        if ($request->hasFile('image')) {
            if ($certification->image) {
                Storage::delete('public/images/' . $certification->image);
            }

            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);
            $certification->image = $imageName;
        }

        $url = route('certification.show', $certification->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeCertification.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $certification->qrcode = $qrCodeName;

        if ($certification->save()) {
            return redirect()->route('certification.index')->with('success', 'Certification updated successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to update certification.');
        }
    }

    public function show($id)
    {
        $certification = Certification::findOrFail($id);
        return view('certification.show', compact('certification'));
    }

    public function destroy($id)
    {
        $certification = Certification::findOrFail($id);

        // Set the related monitoring records to null
        Monitoring::where('certification_id', $certification->id)->update(['certification_id' => null]);

        // Delete the associated image
        $imagePath = 'public/images/' . $certification->image;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }

        // Delete the associated QR code
        $qrCodePath = 'public/qrcodes/' . $certification->qrcode;
        if (Storage::exists($qrCodePath)) {
            Storage::delete($qrCodePath);
        }

        $success = $certification->delete();

        if ($success) {
            return redirect()->route('certification.index')->with('success', 'Certification deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete certification.');
        }
    }

    public function generateCertificate($id)
    {
        $certification = Certification::findOrFail($id);
        $data = [
            'certificate_number' => $certification->certificate_number,
            'issue_date' => $certification->issue_date,
            'nft_token_id' => $certification->nft_token_id,
            'batik_type' => $certification->batik_type,
        ];

        $pdf = Pdf::loadView('certification.certificate', $data)
            ->setPaper('a4', 'landscape');

        // Stream the PDF to the browser
        return $pdf->stream('certificate.pdf');
    }
}
