<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


use App\Http\Controllers\QrCodeController;

Route::post('/generate-qrcode', [QrCodeController::class, 'generateQrCode'])->name('generate.qrcode');



Route::get('/qrcode-form', function () {
    return view('qrcode.form');
});
