<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\QrCodeModel;


class QrCodeController extends Controller
{
    public function generateQrCode(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'link' => 'required|url', // Ensure the input is a valid URL
        ]);

        $link = $validatedData['link'];

        // Generate QR code
        $qrCode = qrcode::format('png')
            ->size(300)
            ->color(150, 0, 0) // RGB for red
            ->generate($link);


        // Save the QR code image in the storage (public folder)
        $fileName = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        // Save QR code data in the database
        $qrCodeModel = new QrCodeModel();
        $qrCodeModel->link = $link;
        $qrCodeModel->qr_code_path = $fileName;
        $qrCodeModel->save();

        // Return the view to display and download the QR code
        return view('qrcode.show', ['qr_code_url' => Storage::url($fileName)]);
    }
}
