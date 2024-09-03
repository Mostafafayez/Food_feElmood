<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\VisitorActionController;
use App\Http\Controllers\AuthController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::get('/allinfo', [RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);

Route::get('/restaurant', [RestaurantController::class, 'get']);
Route::post('/restaurants/search', [RestaurantController::class, 'search']);
Route::post('/restaurants/recommended', [RestaurantController::class, 'getRecommendedRestaurants']);


//admin
Route::middleware(['auth:sanctum', 'sanctum'])->group(function () {
Route::post('/addrestaurant_info', [RestaurantController::class, 'store']);
Route::post('/visitor-actions', [VisitorActionController::class, 'store']);
Route::get('/visitor-actions/counts', [VisitorActionController::class, 'actionCounts']);
});


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-password', [AuthController::class, 'updatePassword']);

