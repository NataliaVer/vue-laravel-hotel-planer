<?php

namespace App\Http\Controllers\BokingRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\BookedRoom;

class DestroyBookedRoomController extends Controller
{
    public function index(BookedRoom $bookingroom) {
        
        if($bookingroom->confirmed) {
            // return back()->withErrors(['err' => "You can't delete confirmed booking"]);
            return "You can't delete confirmed booking";
        }
        $bookingroom->delete();

        $response['status'] = true;
        $response['message'] = 'The reservation has been deleted';

        return $response;
    }
}
