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

Route::group(['middleware' => ['auth:sanctum']], function () {
    // Route::post('/signin/login', [App\Http\Controllers\Auth\LoginController::class,'login'])->name('signin.login');
    Route::get('/get', [App\Http\Controllers\GetController::class, 'index']);
    // Route::get('/getUser', [App\Http\Controllers\Auth\LoginController::class, 'getUser']);
});
// Route::get('/get', [App\Http\Controllers\GetController::class, 'index']);
Route::get('/isGuest', [App\Http\Controllers\Auth\UserController::class, 'isGuest']);
Route::get('/getUser', [App\Http\Controllers\Auth\UserController::class, 'index']);
Route::post('/forgot-password',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password',[App\Http\Controllers\Auth\NewPasswordController::class, 'store']);


