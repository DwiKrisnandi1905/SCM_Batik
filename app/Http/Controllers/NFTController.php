<?php

namespace App\Http\Controllers;

use App\Services\NFTService;
use Illuminate\Http\Request;
use App\Models\NFT;

class NFTController extends Controller
{
    protected $nftService;

    public function __construct(NFTService $nftService)
    {
        $this->nftService = $nftService;
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

    
    public function updateNFTConfig(Request $request)
    {
        try {
            $nftConfig = NFT::findOrFail(1);
            $nftConfig->fromAddress = $request->fromAddress;
            $nftConfig->contractAddress = $request->contractAddress;
            $nftConfig->abi = $request->abi;
            $nftConfig->save();

            return redirect()->route('admin.index')
                ->with('success', 'NFT config updated successfully');
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Failed to update NFT config');
        }
    }

    public function editNFTConfig()
    {
        $nftConfig = NFT::findOrFail(1);
        return view('nft.edit', compact('nftConfig'));
    }
    
}
