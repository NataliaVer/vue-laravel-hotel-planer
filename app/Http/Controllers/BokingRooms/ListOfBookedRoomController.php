<?php

namespace App\Http\Controllers\BokingRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

use App\Models\BookedRoom;

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

            // return back()->withErrors(['message' => 'Do not valide date']);
        }

        $rooms = DB::table('rooms')
                   ->select('name', 'price', 'count_one_bed', 'count_two_bed', DB::raw('id as room_id'))
                   ->where('rooms.user_id', '=', $user->id);

        $booked_rooms = DB::table('booked_rooms')->select('*')
                                                 ->whereBetween('booked_rooms.date_from', [$dateFrom, $dateTo])
                                                 // ->orWhere('created_at', '<=', $dateTo)
                                                 ->JoinSub($rooms, 'rooms', function ($join) {
                                                     $join->on('booked_rooms.room_id', '=', 'rooms.room_id');
                                                 })->get();

        return $booked_rooms;
    }
}
