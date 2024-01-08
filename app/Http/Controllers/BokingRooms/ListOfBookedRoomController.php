<?php

namespace App\Http\Controllers\BokingRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\BookedRoom;
use App\Models\Room;

//Seach boocked roooms on date for user office
class ListOfBookedRoomController extends Controller
{
    public function index($dateFrom, $dateTo) {
        $user = Auth::user();

        $newBookedRoom = new BookedRoom();

        if (!$dateFrom || !$dateTo || !$newBookedRoom->validateDate($dateFrom, 'Y-m-d') || !$newBookedRoom->validateDate($dateTo, 'Y-m-d')) {
            $response['status'] = false;
            $response['message'] = 'Do not valide date';
            return $response;

            //it is not for delete metod, only use get
            // return back()->withErrors(['message' => 'Do not valide date']);
        }

        $rooms = Room::where('rooms.user_id', '=', $user->id)
                   ->select('name', 'price', DB::raw('id as room_id'));

        $booked_rooms = BookedRoom::whereBetween('booked_rooms.date_from', [$dateFrom, $dateTo])
                                                 // ->orWhere('created_at', '<=', $dateTo)
                                                 ->JoinSub($rooms, 'rooms', function ($join) {
                                                     $join->on('booked_rooms.room_id', '=', 'rooms.room_id');
                                                 })->get();

        foreach($booked_rooms as $booked_room) {
            $booked_room['translations'] = $booked_room->room->translations;
        }
                                                 
        return $booked_rooms;
    }

    //will need to check if this user have rooms in hotel
    //before create reservations
    public function UsersRooms() {

        $user = Auth::user();
        $rooms = $user->rooms;

        foreach($rooms as $room) {
            $room['translations'] = $room->translations;
        }

        return $rooms;
    }
}
