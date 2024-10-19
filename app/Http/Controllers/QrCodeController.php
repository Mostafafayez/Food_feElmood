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

        // First, create a new QrCodeModel and save it to get the ID
        $qrCodeModel = new QrCodeModel();
        $qrCodeModel->link = $link; // Original link, not the scan route yet
        $qrCodeModel->qr_code_path = ''; // Temporarily empty, will be updated later
        $qrCodeModel->save();

        // Generate the QR code with the tracking route using the saved model's ID
        $trackingLink = route('qrcode.scan', ['id' => $qrCodeModel->id]);

        $qrCode = QrCode::format('png')
            ->size(200)
            ->color(0, 0, 0) // RGB for red
            ->generate($trackingLink);

        // Save the QR code image in the storage (public folder)
        $fileName = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        // Update the qr_code_path in the model
        $qrCodeModel->qr_code_path = $fileName;
        $qrCodeModel->save(); // Save the updated file path

        // Return the view to display and download the QR code
        return view('qrcode.show', ['qr_code_url' => Storage::url($fileName)]);
    }




    public function trackScan($id)
{
    // Find the QR code by its ID
    $qrCodeModel = QrCodeModel::findOrFail($id);

    // Increment the scan count
    $qrCodeModel->scans_count = $qrCodeModel->scans_count + 1;
    $qrCodeModel->save();

    // Redirect the user to the original link
    return redirect($qrCodeModel->link);
}

}
