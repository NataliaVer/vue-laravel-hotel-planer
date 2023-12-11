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

            // $translations = $hotel[0]->translations;

            return [
                'hotel' => $hotel,
                'photos' => $photos,
                'translations' => count($hotel)>0 ? $hotel[0]->translations : [],
            ];
    }
}
