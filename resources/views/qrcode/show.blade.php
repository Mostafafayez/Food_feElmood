<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Viewer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            text-align: center;
            padding: 20px;
        }
        .qr-container {
            margin-top: 50px;
        }
        .qr-container img {
            width: 300px;
            height: 300px;
            margin-bottom: 20px;
        }
        .logo-container {
            position: absolute; /* Use absolute positioning */
            top: 20px; /* Distance from the top */
            left: 20px; /* Distance from the left */
        }
        .logo {
            width: 100px; /* Adjust the size as needed */
            height: auto; /* Maintain aspect ratio */
            /* margin-bottom: 20px; */
        }
        .download-btn {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
            cursor: pointer;
        }
        .download-btn:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Generated QR Code</h1>

    <!-- Logo Section -->
    <div class="logo-container">
        <img src="{{ asset('storage/qrcodes/logo.png') }}" alt="Logo" class="logo">
    </div>

    <!-- QR Code Section -->
    <div class="qr-container">
        <img src="{{ asset($qr_code_url) }}" alt="QR Code">
    </div>

    <a href="{{ asset($qr_code_url) }}" class="download-btn" download="qrcode.png">Download QR Code</a>
</body>
</html>
