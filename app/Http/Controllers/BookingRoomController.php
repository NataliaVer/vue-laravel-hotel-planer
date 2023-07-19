<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\Room\BookingRoomRequest;

use App\Models\Room;

class BookingRoomController extends Controller
{
    public function bookRoom(BookingRoomRequest $request) {

        // return $req;
        $data = $request->validated();

        // return $data;

        $id = $request->post('id');

        $room = Room::find($id);

        if (!$room) {
            $response['status'] = false;
            $response['message'] = 'Кімнату не знайдено, перезавантажте сторінку і спробуйте ще раз';
        }
        // return $data;
        $boked_room = $room->booked_rooms()->create([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'email' => $request->email,
                'phone' => $request->phone,
                'confirmed' => false,
                'date_from' => $request->date_from,
                'date_to' => $request->date_to
            ]);

        $response['status'] = true;
        $response['id'] = $room->id;

        return $response;
    }
}
