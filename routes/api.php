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

Route::group(['middleware' => ['auth']], function () {
    // Route::post('/signin/login', [App\Http\Controllers\Auth\LoginController::class,'login'])->name('signin.login');
    Route::get('/get', [App\Http\Controllers\GetController::class, 'index']);
    // Route::get('/getUser', [App\Http\Controllers\Auth\LoginController::class, 'getUser']);
});
// Route::get('/get', [App\Http\Controllers\GetController::class, 'index']);
Route::get('/isGuest', [App\Http\Controllers\Auth\UserController::class, 'isGuest']);
Route::get('/getUser', [App\Http\Controllers\Auth\UserController::class, 'index'])->middleware('auth');
Route::post('/forgot-password',[App\Http\Controllers\Auth\ForgotPasswordController::class, 'forgotPassword']);
Route::post('/reset-password',[App\Http\Controllers\Auth\NewPasswordController::class, 'store']);
Route::put('/updateUser',[App\Http\Controllers\Auth\ChangeUserDataController::class, 'index'])->middleware('auth');

Route::get('/getHotel',[App\Http\Controllers\Hotels\GetHotelController::class, 'index'])->middleware('auth');
Route::post('/hotel/create',[App\Http\Controllers\Hotels\StoreHotelController::class, 'index'])->middleware('auth');
Route::delete('/hotel/{hotel}',[App\Http\Controllers\Hotels\DestroyHotelController::class, 'index'])->middleware('auth');
Route::post('/hotelUpdate/{hotel}',[App\Http\Controllers\Hotels\UpdateHotelController::class, 'index'])->middleware('auth');

Route::get('/getRooms',[App\Http\Controllers\Rooms\GetRoomsController::class, 'index'])->middleware('auth');
Route::post('/roomUpdate/{room}',[App\Http\Controllers\Rooms\UpdateRoomController::class, 'index'])->middleware('auth');
Route::post('/room/create',[App\Http\Controllers\Rooms\StoreRoomController::class, 'index'])->middleware('auth');
Route::delete('/room/{room}',[App\Http\Controllers\Rooms\DestroyRoomController::class, 'index'])->middleware('auth');

Route::get('/searchBookedRooms/{dateFrom}/{dateTo}', [App\Http\Controllers\BokingRooms\ListOfBookedRoomController::class, 'index'])->middleware('auth');
Route::get('/confirmBooking/{id}/{action}', [App\Http\Controllers\BokingRooms\UpdateBookedRoomController::class, 'confirmOrCancelBooking'])->middleware('auth');
Route::post('/bookingRoom/update/{bookedRoom}', [App\Http\Controllers\BokingRooms\UpdateBookedRoomController::class, 'index'])->middleware('auth');
Route::delete('/bookingRoom/{bookingroom}', [App\Http\Controllers\BokingRooms\DestroyBookedRoomController::class, 'index'])->middleware('auth');
Route::get('/listAvialableRooms/{id}/{dateFrom}/{dateTo}', [App\Http\Controllers\BokingRooms\UpdateBookedRoomController::class, 'allAvialableRoomsToDateByUser'])->middleware('auth');
Route::post('/storeBookingRoom', [App\Http\Controllers\BokingRooms\StoreBookedRoomController::class, 'index'])->middleware('auth');
Route::get('/ThisUserHasRooms', [App\Http\Controllers\BokingRooms\ListOfBookedRoomController::class, 'UsersRooms'])->middleware('auth');

