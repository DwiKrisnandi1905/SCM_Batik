<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Dompdf\Dompdf;
use Dompdf\Options;

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
        $qrCodeImage = base64_encode(QrCode::format('png')->size(150)->generate(route('batik.show', ['id' => $certification->monitoring_id])));

        $html = '
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Certificate</title>
            <style>
                    html, body {
            height: 100%;
            margin: 0;
        }
                body {
                    font-family: "Montserrat", sans-serif;
                    background-color: #fffaf0;
                    background: radial-gradient(circle, rgba(255, 250, 240, 1) 0%, rgba(245, 245, 245, 1) 100%);
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    margin: 0;
                    position: relative;
                    overflow: hidden;
                }
                .certificate {
                    border: 15px solid #d4af37;
                    padding: 50px 80px;
                    background: linear-gradient(to bottom, #ffffff, #f8f9fa);
                    box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
                    max-width: 950px;
                    max-height: 850px;
                    text-align: center;
                    position: relative;
                    overflow: hidden;
                }
                .certificate::before, .certificate::after {
                    content: "";
                    position: absolute;
                    border: 1px solid #d4af37;
                    border-radius: 50%;
                    width: 500px;
                    height: 500px;
                    top: -250px;
                    left: -250px;
                    background: radial-gradient(circle, rgba(212, 175, 55, 0.2) 0%, rgba(255, 250, 240, 0) 70%);
                    animation: rotate 15s linear infinite;
                }
                .certificate::after {
                    width: 600px;
                    height: 700px;
                    top: auto;
                    bottom: -300px;
                    left: auto;
                    right: -300px;
                    background: radial-gradient(circle, rgba(212, 175, 55, 0.1) 0%, rgba(255, 250, 240, 0) 80%);
                    animation: rotate-reverse 20s linear infinite;
                }
                @keyframes rotate {
                    from { transform: rotate(0deg); }
                    to { transform: rotate(360deg); }
                }
                @keyframes rotate-reverse {
                    from { transform: rotate(360deg); }
                    to { transform: rotate(0deg); }
                }
                .header {
                    font-size: 48px;
                    font-weight: bold;
                    color: #d4af37;
                    margin-bottom: 20px;
                    margin-top: 80px;
                    font-family: "Great Vibes", cursive;
                }
                .subheader {
                    font-size: 24px;
                    color: #6c757d;
                    margin-bottom: 10px;
                    font-style: italic;
                }
                .recipient {
                    font-size: 28px;
                    margin: 20px 0;
                    font-weight: 700;
                    color: #343a40;
                }
                .batik-name {
                    font-size: 22px;
                    color: #495057;
                    margin-bottom: 20px;
                    font-weight: 600;
                }
                .body {
                    font-size: 20px;
                    color: #6c757d;
                    margin-bottom: 40px;
                }
                .nft {
                    font-size: 16px;
                    color: #495057;
                    word-wrap: break-word;
                    background-color: #f8f9fa;
                    padding: 10px;
                    border: 2px solid #d4af37;
                    border-radius: 5px;
                    margin-bottom: 30px;
                    font-family: "Courier New", Courier, monospace;
                }
                .footer {
                    font-size: 16px;
                    margin-top: 40px;
                    color: #343a40;
                }
                .qr-code {
                    margin-top: 40px;
                    margin-bottom: 28px;
                }
                .qr-code img {
                    max-width: 100px; /* Adjust this as needed */
                    max-height: 100px; /* Adjust this as needed */
                    width: auto;
                    height: auto;
                }
            </style>
        </head>
        <body>
            <div class="certificate">
                <div class="header">Certificate of Batik Ownership</div>
                <div class="subheader">In recognition of rightful ownership of batik</div>
                <div class="recipient">' . $certification->certificate_number . '</div>
                <div class="batik-name">' . $certification->batik_type . '</div>
                <div class="body">
                    Awarded as proof of rightful ownership of batik. Like the intricate designs of batik, your ownership is unique and valuable.
                </div>
                <div class="nft">' . $certification->nft_token_id . '</div>
                <div class="footer">Date:' . $certification->issue_date . '</div>
                                <div class="qr-code">
                                
                           <img src="data:image/png;base64,' . $qrCodeImage . '" alt="QR Code">
                                </div>


            </div>
        </body>
        </html>
        ';


        // Create a new Dompdf instance
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);

        // Load the HTML content
        $dompdf->loadHtml($html);

        // Set paper size and orientation
        $dompdf->setPaper('A4', 'landscape');

        // Render the PDF
        $dompdf->render();

        // Output the generated PDF
        return $dompdf->stream('certificate.pdf');
    }

}
