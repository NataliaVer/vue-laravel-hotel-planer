<?php

namespace App\Http\Controllers\BokingRooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\Room;

use  App\Http\Requests\BookedRoom\UpdateBookedRoomRequest;

use App\Models\BookedRoom;

class UpdateBookedRoomController extends Controller
{
    public function index(UpdateBookedRoomRequest $request, BookedRoom $bookedRoom) {

        $data = $request->validated();

        $bookedRoom->update($data);

        return $bookedRoom;
    }

    public function confirmOrCancelBooking($id, $action) {

        $booked_room = BookedRoom::find($id);

        if(!$booked_room) {
            $response['status'] = false;
            $response['message'] = 'Бронювання не знайдено, обновіть сторінку і спробуйте ще раз';

            return $response;
        }

        if($action == '1') {
            $booked_room->update(["confirmed" => 1]);
        } elseif ($action == '0') {
            $booked_room->update(["confirmed" => 0]);
        }

        return $booked_room;
    }

    //список доступних кімнат аутентифікованого користувача
    //на період
    public function allAvialableRoomsToDateByUser($id, $dateFrom, $dateTo) {

        $user = Auth::user();
        $newBookedRoom = new BookedRoom();

        if (!$dateFrom || !$dateTo || !is_numeric($id) || !$newBookedRoom->validateDate($dateFrom, 'Y-m-d') || !$newBookedRoom->validateDate($dateTo, 'Y-m-d')) {

            $rooms = $user->rooms;
            foreach($rooms as $room) {
                $room['translations'] = $room->translations;
            }
            
            return $rooms;
        }

        $rooms = $user->rooms->pluck('id')->toArray();

        $booked_rooms = $this->freeRoomsByDate($rooms, $id, $dateFrom, $dateTo);

        $roomsAvailable = Room::where('user_id','=', $user->id)
                                    ->leftJoinSub($booked_rooms, 'booked_rooms', function ($join) {
                                        $join->on('rooms.id', '=', 'booked_rooms.room_id');
                                    })
                                    ->get();

        foreach($roomsAvailable as $room) {
            $room['translations'] = $room->translations;
        }

        return $roomsAvailable;
    }

    //від загальної кількості кімнат певного виду відняти уже заброньовані кімнати
    //без тієї що змінюємо (один запит на Add та Edit), якщо її id передано в запиті
    public function freeRoomsByDate($rooms, $id, $dateFrom, $dateTo) {
        return  BookedRoom::select(DB::raw('count(*) as booked_rooms_count, room_id'))
                                                ->whereIn('room_id', $rooms)
                                                ->where('id', "<>", ($id ? $id : ""))
                                                //над confirmed треба ще подумати,
                                                //як воно повинно працювати,
                                                //можливо б це була альтернатива "Оплачено"
                                                // ->where('confirmed', '1')
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
    }

}
