<?php

namespace App\Http\Controllers\BokingRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BookedRoom;

use  App\Http\Requests\BookedRoom\StoreBookedRoomRequest;

class StoreBookedRoomController extends Controller
{
    public function index(StoreBookedRoomRequest $request) {

        $data = $request->validated();

        $bookedRoom = BookedRoom::create($data);

        return $bookedRoom;
    }
}
