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
    public function generateQrCodes(Request $request)
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
            ->backgroundColor(255, 255, 255)
            ->size(200)
            ->color(0, 0, 0) 
            ->merge(Storage::path('public/qrcodes/logo.png'), 0.2, true)// RGB for red
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




    public function generateQrCode()
{
    // Define static Wi-Fi credentials
    $ssid = 'TP-Link_B6620'; // Static SSID
    $password = 'ofx205033'; // Static password
    $encryption = 'WPA'; // Static encryption type

    // Create the Wi-Fi QR code format
    $qrCodeData = 'WIFI:T:' . strtoupper($encryption) . ';S:' . $ssid . ';P:' . $password . ';;';

    // Create a new QrCodeModel entry in the database
    $qrCodeModel = new QrCodeModel();
    $qrCodeModel->link = $qrCodeData; // Save the Wi-Fi credentials in the link field
    $qrCodeModel->qr_code_path = ''; // Will be updated after generating the QR code
    $qrCodeModel->save();

    // Generate the QR code with the static Wi-Fi credentials
    $qrCode = QrCode::format('png')
        ->size(300)
        ->generate($qrCodeData);

    // Save the QR code image in the storage (public folder)
    $fileName = 'qrcodes/static_wifi_' . uniqid() . '.png';
    Storage::disk('public')->put($fileName, $qrCode);

    // Update the QR code path in the database
    $qrCodeModel->qr_code_path = $fileName;
    $qrCodeModel->save();

    // Return the view to display and download the QR code
    return view('qrcode.show', ['qr_code_url' => Storage::url($fileName)]);
}



    public function generateQrCodeapi(Request $request)
    {
        // Validate incoming data
        $validatedData = $request->validate([
            'link' => 'required', // Ensure the input is a valid URL
        ]);

        $link = $validatedData['link'];

        // Create a new QrCodeModel and save the link
        $qrCodeModel = new QrCodeModel();
        $qrCodeModel->link = $link;
        $qrCodeModel->qr_code_path = ''; // Temporarily empty, will be updated later
        $qrCodeModel->save();

        // Generate the QR code with the tracking route using the saved model's ID
        $trackingLink = route('qrcode.scan', ['id' => $qrCodeModel->id]);

        $qrCode = QrCode::format('png')
            ->backgroundColor(255, 255, 255)
            ->size(200)
            ->color(0, 0, 0)
            ->style('dot')                   // Change pattern to dots
            ->eye('square')  
            ->generate($trackingLink);

        // Save the QR code image in the storage (public folder)
        $fileName = 'qrcodes/' . uniqid() . '.png';
        Storage::disk('public')->put($fileName, $qrCode);

        // Update the qr_code_path in the model
        $qrCodeModel->qr_code_path = $fileName;
        $qrCodeModel->save();

        // Return the QR code URL as a JSON response
        return response()->json([
            'qr_code_url' => Storage::url($fileName),
            'tracking_link' => $trackingLink
        ]);
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
            if (isset($userLocation->ip) && isset($userLocation->countryName) && isset($userLocation->cityName)) {
                // Saving the location data in the database
                $qrCodeModel->user_location = json_encode([
                    'ip' => $userLocation->ip,
                    'country' => $userLocation->countryName,
                    'city' => $userLocation->cityName,
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




    public function trackScanapi($id, Request $request)
    {
        // Find the QR code by its ID
        $qrCodeModel = QrCodeModel::findOrFail($id);

        // Get the user's location based on their IP address
        $userLocation = Location::get($request->ip());

        // Increment the scan count
        $qrCodeModel->scans_count += 1;
        $qrCodeModel->save();

        // Optionally: Save the location data if needed
        if ($userLocation && isset($userLocation->ip, $userLocation->countryName, $userLocation->cityName)) {
            // Save user location in the database
            $qrCodeModel->user_location = json_encode([
                'ip' => $userLocation->ip,
                'country' => $userLocation->countryName,
                'city' => $userLocation->cityName,
                'latitude' => $userLocation->latitude,
                'longitude' => $userLocation->longitude,
            ]);
            $qrCodeModel->save();
        }

        // Return a JSON response with the user's location and original link
        return response()->json([
            'original_link' => $qrCodeModel->link,
            'scans_count' => $qrCodeModel->scans_count,
            'user_location' => $userLocation ? [
                'ip' => $userLocation->ip,
                'country' => $userLocation->countryName,
                'city' => $userLocation->cityName,
                'latitude' => $userLocation->latitude,
                'longitude' => $userLocation->longitude,
            ] : null
        ]);
    }
}
