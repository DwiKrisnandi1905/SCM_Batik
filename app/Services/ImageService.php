<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ImageService
{
    public function handleImageUpload($image)
    {
        $imageName = time() . '.' . $image->getClientOriginalExtension();
        $image->storeAs('public/images', $imageName);
        return $imageName;
    }

    public function createNftToken($tokenURI, $fromAddress, $nftService)
    {
        return $nftService->createToken($tokenURI, $fromAddress);
    }

    public function generateQrCode($harvestId)
    {
        $url = route('harvests.show', $harvestId);
        $qrCode = QrCode::format('svg')->size(300)->generate($url);
        $qrCodeName = time() . '_qrcode.svg';
        Storage::disk('public')->put('qrcodes/' . $qrCodeName, $qrCode);
        return $qrCodeName;
    }

    public function deleteImage($imageName, $path = 'public/images')
    {
        $imagePath = $path . '/' . $imageName;
        if (Storage::exists($imagePath)) {
            Storage::delete($imagePath);
        }
    }
}
