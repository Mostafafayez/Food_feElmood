<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Storage;
use App\Models\QrCodeModel;
use Stevebauman\Location\Facades\Location;
use Illuminate\Support\Facades\Log;

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




    public function trackScan($id, Request $request)
    {
        // Find the QR code by its ID
        $qrCodeModel = QrCodeModel::findOrFail($id);

        // Get the user's location based on their IP address
        $userLocation = Location::get($request->ip());

        // Increment the scan count
        $qrCodeModel->scans_count += 1; // Simplified increment
        $qrCodeModel->save();





        // Optionally: Save the location data if needed
        if ($userLocation) {
            // Log or save user location details as needed
            // Check if userLocation is an object and has the expected properties
            if (isset($userLocation->ip) && isset($userLocation->countryName) ) {
                // Saving the location data in the database
                $qrCodeModel->user_location = json_encode([
                    'ip' => $userLocation->ip,
                    'country' => $userLocation->countryName,
                    // 'city' => $userLocation->city,
                    'latitude' => $userLocation->latitude,
                    'longitude' => $userLocation->longitude,
                ]);
                $qrCodeModel->save();
            }

            Log::info('User Location to be saved:', [
                'user_location' => json_encode([
                    'ip' => $userLocation->ip,
                    'country' => $userLocation->countryName,
                    'city' => $userLocation->cityName,
                    'latitude' => $userLocation->latitude,
                    'longitude' => $userLocation->longitude,
                ]),
            ]);

        }

        // Redirect the user to the original link
        return redirect($qrCodeModel->link);
    }

}
