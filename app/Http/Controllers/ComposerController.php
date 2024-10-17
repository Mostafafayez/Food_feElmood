<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

class ComposerController extends Controller
{
    public function requireQrcode(Request $request)
    {
        // Define the command to run
        $process = new Process(['composer', 'require', 'simplesoftwareio/simple-qrcode']);

        // Execute the command
        $process->run();

        // Check if the process succeeded
        if (!$process->isSuccessful()) {
            // Return the error output
            return response()->json([
                'message' => 'Failed to install package',
                'error' => $process->getErrorOutput()
            ], 500);
        }

        return response()->json(['message' => 'Package simplesoftwareio/simple-qrcode installed successfully!']);
    }
}
