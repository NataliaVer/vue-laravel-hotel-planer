<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class GetRoomsController extends Controller
{
    public function index() {

            $user = Auth::user();
            $hotel = $user->hotel;
            $rooms = $user->rooms;
            $photos = $user->photos;

            return [
                'hotel'=>$hotel,
                'rooms'=>$rooms,
                'photos'=>$photos
            ];
        
    }
}
