<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

use App\Services\{
    NFTService,
    ImageService
};

use App\Models\{
    Monitoring,
    NFT,
    Craftsman,
    Certification
};

class CertificationController extends Controller
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

        $certifications = $role->id == 1
            ? Certification::all()
            : Certification::where('user_id', $user->id)->get();

        return view('certification.index', compact('certifications'))->with([
            'name' => 'certification',
            'title' => 'Certification'
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
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:4096'
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
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $certification->image = $imageName;

            $tokenURI = url('storage/images/' . $imageName);
            $fromAddress = NFT::first()->fromAddress;

            if ($fromAddress) {
                $transactionHash = $this->imageService->createNftToken($tokenURI, $fromAddress, $this->nftService);
                $certification->nft_token_id = $transactionHash;
            }
        }

        $certification->save();

        $qrCodeName = $this->imageService->generateQrCode($certification->id);
        $certification->qrcode = $qrCodeName;
        $certification->save();

        $craftsman = Craftsman::find($validated['craftsman_id']);
        $craftsman->is_ref = 1;
        $craftsman->save();

        $monitoring = Monitoring::where('craftsman_id', $certification->craftsman_id)->first();
        if ($monitoring) {
            $monitoring->certification_id = $certification->id;
            $monitoring->last_updated = now();
            $monitoring->save();
        } else {
            $monitoring = new Monitoring([
                'certification_id' => $certification->id,
                'last_updated' => now(),
                'craftsman_id' => $certification->craftsman_id,
            ]);
            $monitoring->save();
        }

        $certification->monitoring_id = $monitoring->id;
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

        $validated = $request->validate([
            'craftsman_id' => 'required|exists:craftsmen,id',
            'batik_type' => 'required|string|max:255',
            'test_results' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:4096',
        ]);

        $certification->user_id = $user_id;
        $certification->craftsman_id = $validated['craftsman_id'];
        $certification->batik_type = $validated['batik_type'];
        $certification->test_results = $validated['test_results'];
        $certification->certificate_number = $validated['certificate_number'];
        $certification->issue_date = $validated['issue_date'];

        if ($request->hasFile('image')) {
            $this->imageService->deleteImage($certification->image);
            $imageName = $this->imageService->handleImageUpload($request->file('image'));
            $certification->image = $imageName;
        }

        $url = route('certification.show', $certification->id);
        $qrCodeName = $this->imageService->generateQrCode($url);
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
        Monitoring::where('certification_id', $certification->id)->update(['certification_id' => null]);

        $this->imageService->deleteImage($certification->image);
        $this->imageService->deleteImage($certification->qrcode, 'public/qrcodes');

        if ($certification->delete()) {
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

        return $pdf->stream('certificate.pdf');
    }
}
