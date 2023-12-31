<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Models\Room;

use Illuminate\Support\Facades\DB;

class HotelController extends Controller
{
    public function show(Hotel $hotel, $dateFrom, $dateTo) {

        $photos =  $hotel->photos;
        $hotel_translations = $hotel->translations;

        //умова whereBetween в значенні >= і <=, а нам потрібно > і <

        $booked_rooms = DB::table('booked_rooms')->select(DB::raw('count(*) as booked_rooms_count, room_id'))
                                                 ->where('confirmed', '=', true)
                                                 ->where(function($query) use ($dateFrom, $dateTo) {
                                                   $query->where('date_from', '>', $dateFrom)
                                                         ->where('date_from', '<', $dateTo)
                                                         ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                           $query->where('date_to', '>', $dateFrom)
                                                                 ->Where('date_to', '<', $dateTo);
                                                           })
                                                         ->orWhere(function($query) use ($dateFrom, $dateTo) {
                                                           $query->where('date_from', '<=', $dateFrom)
                                                                 ->Where('date_to', '>=', $dateTo);
                                                           });
                                                  })
                                                 ->groupBy('room_id');


        $rooms = Room::where('hotel_id','=', $hotel->id)
                                    ->leftJoinSub($booked_rooms, 'booked_rooms', function ($join) {
                                        $join->on('rooms.id', '=', 'booked_rooms.room_id');
                                    })
                                   ->get();

        foreach($rooms as $room) {
          $room_translations = $room->translations;
          $room['translations'] = $room_translations;
        }
        
        $response['hotel'] = $hotel;
        $response['rooms'] = $rooms;
        $response['photos'] = $photos;
        $response['hotel_translations'] = $hotel_translations;

        return $response;

    }
}
