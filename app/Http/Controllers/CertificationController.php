<?php
namespace App\Http\Controllers;

use App\Services\NFTService;
use App\Models\Certification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Craftsman;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;

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
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Ensure image is validated
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

        //  $tokenURI = url('public/images/' . $imageName); 
        //  $fromAddress = '0x82494581249EeE88c97C949eEC16226789677f42'; 
        //  $transactionHash = $this->nftService->createToken($tokenURI, $fromAddress);
 
        //  $certification->nft_token_id = $transactionHash;

        $certification->save();

        $url = route('certification.show', $certification->id);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);

        $qrCodeName = time() . '_qrcodeCertification.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        $certification->qrcode = $qrCodeName;
    
        if ($certification->save()) {
            $Craftsman = Craftsman::find($validated['craftsman_id']);
            $Craftsman->is_ref = 1;
            $Craftsman->save();
            return redirect()->route('certification.index')->with('success', 'Certification created successfully.');
        } else {
            return redirect()->back()->with('error', 'Failed to create certification.');
        }
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

    public function generateCertificate($name, $course, $date)
    {
        // Prepare data to be passed to the view
        $data = [
            'name' => $name,
            'course' => $course,
            'date' => $date,
        ];

        // Load the view and pass the data
        $pdf = Pdf::loadView('certification/certificate', $data);

        // Stream the PDF to the browser
        return $pdf->stream('certificate.pdf');
    }
}