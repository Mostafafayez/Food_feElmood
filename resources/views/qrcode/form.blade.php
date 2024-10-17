<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Generate QR Code</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            text-align: center;
        }
        form {
            margin-top: 50px;
        }
        input[type="text"] {
            padding: 10px;
            width: 300px;
            margin-bottom: 20px;
        }
        button {
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        button:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <h1>Generate QR Code</h1>
    <form action="{{ route('generate.qrcode') }}" method="POST">
        @csrf
        <input type="text" name="link" placeholder="Enter URL" required>
        <br>
        <button type="submit">Generate QR Code</button>
    </form>
</body>
</html>
