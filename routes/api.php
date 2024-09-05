<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RestaurantController;
use App\Http\Controllers\VisitorActionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FoodTypeController;
use App\Http\Controllers\FoodSpinerController;
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');




Route::get('/allinfo', [RestaurantController::class, 'index']);
Route::get('/restaurants/{id}', [RestaurantController::class, 'show']);
//restaurants
Route::get('/restaurant', [RestaurantController::class, 'get']);
Route::post('/restaurants/search', [RestaurantController::class, 'search']);
Route::post('/restaurants/recommended', [RestaurantController::class, 'getRecommendedRestaurants']);

Route::get('/restaurants/food/{food_id}', [RestaurantController::class, 'getByFoodId']);



//ranked &randomly
Route::post('restaurants/random', [RestaurantController::class, 'getAllRestaurantsRandomly']);
Route::post('/restaurants/sorted-by-price', [RestaurantController::class, 'getRestaurantsSortedByPrice']);
//admin
Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/visitor-actions/counts', [VisitorActionController::class, 'actionCounts']);
Route::post('/addrestaurant_info', [RestaurantController::class, 'store']);
Route::post('/visitor-actions', [VisitorActionController::class, 'store']);

});


Route::post('/signup', [AuthController::class, 'signup']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/update-password', [AuthController::class, 'updatePassword']);

//admin_spiner-food
Route::middleware(['auth:sanctum'])->group(function () {
Route::get('/spiner-food', [FoodTypeController::class, 'index']);
Route::post('/spiner-food', [FoodTypeController::class, 'store']);
Route::put('/spiner-food/{id}', [FoodTypeController::class, 'update']);
Route::delete('/spiner-food/{id}', [FoodTypeController::class, 'destroy']);
});



Route::get('/spiner-food/active', [FoodSpinerController::class, 'getAllFoodsWithStatusTrue']);
Route::get('/spiner-food/wheel', [FoodSpinerController::class, 'getMostPriorityFood']);





/////////comment