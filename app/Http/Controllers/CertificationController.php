<?php
namespace App\Http\Controllers;

use App\Services\NFTService;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Craftsman;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

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
        return view('certification.index', compact('certifications'));
    }

    public function create()
    {
        $craftsmen = Craftsman::all();
        return view('certification.create', compact('craftsmen'));
    }

    public function store(Request $request)
    {
        $user_id = auth()->id();
        $validated = $request->validate([
            'craftsman_id' => 'required|integer|exists:craftsmen,id',
            'test_results' => 'required|string|max:255',
            'certificate_number' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is validated
        ]);
    
        $certification = new Certification();
        $certification->user_id = $user_id;
        $certification->craftsman_id = $validated['craftsman_id'];
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
        return view('certification.edit', compact('craftsmen', 'certification'));
    }

    public function update(Request $request, $id)
    {
        $user_id = auth()->id();
        $certification = Certification::findOrFail($id);
        $certification->user_id = $user_id;
        $certification->craftsman_id = $request->craftsman_id;
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
        $image = $certification->image;
        if ($image && $image !== 'default') {
            Storage::delete('public/images/' . $image);
        }
        $success = $certification->delete();
        if ($success) {
            return redirect()->route('certification.index')->with('success', 'Certification deleted successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to delete certification.');
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

    public function generateCertificate($id)
    {
        $certification = Certification::findOrFail($id);
        $data = [
            'certificate_number' => $certification->certificate_number,
            'issue_date' => $certification->issue_date,
        ];

        $pdf = Pdf::loadView('certification.certificate', $data)
            ->setPaper('a4', 'landscape');

        // Stream the PDF to the browser
        return $pdf->stream('certificate.pdf');
    }

}