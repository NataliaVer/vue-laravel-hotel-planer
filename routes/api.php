<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Hotels\HotelController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('/searchCity', [App\Http\Controllers\SearchController::class, 'searchCity']);

Route::post('/searchHotels', [App\Http\Controllers\SearchController::class, 'searchHotels']);

Route::get('/hotel/{hotel}/{dateFrom}/{dateTo}', [HotelController::class, 'show']);

Route::post('/bookingroom', [App\Http\Controllers\BookingRoomController::class, 'bookRoom']);

Route::group(['middleware' => ['api']], function () {
    Route::post('/signin/login', [App\Http\Controllers\Auth\LoginController::class,'login'])->name('signin.login');
});


