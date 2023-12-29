<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Models\Room;

class DestroyRoomController extends Controller
{
    public function index(Room $room) {
        //видалити кімнату можна, якщо для неї не створено бронювань,
        //тут можна буде зробити розділення прав, і додати можливість
        //видалення всіх данних, лише для адміна

        $booked_rooms = $room->booked_rooms;

        if(!$booked_rooms == null && !count($booked_rooms)>0) {
            //delete with photo
            $photos = $room->photos;
            foreach ($photos as $photo) {
                $path = str_replace('/storage/', '',$photo->photo);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                    }
            }

            $room->translations()->delete();
            $room->photos()->delete();
            $room->delete();

            $response['status'] = true;
            $response['message'] = 'The room was deleted successfully';
            return $response;
        }

        $response['status'] = false;
        $response['message'] = 'It is not possible to delete the room, it has a reservation';
        return response($response, 422);
    }
}
