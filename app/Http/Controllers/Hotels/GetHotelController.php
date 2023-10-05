<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetHotelController extends Controller
{
    public function index() {

            $user = Auth::user();
            $hotel = $user->hotel;
            $photos = $user->photos;

            return [
                'hotel' => $hotel,
                'photos' => $photos
            ];
    }
}
