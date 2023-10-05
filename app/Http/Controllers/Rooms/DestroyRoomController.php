<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

use App\Models\Room;

class DestroyRoomController extends Controller
{
    public function index(Room $room) {
        //видалити кімнату можна, якщо для неї не створено бронювань,
        //тут можна буде зробити розділення прав, і додати можливість
        //видалення всіх данних, лише для адміна

        $booked_rooms = $room->booked_rooms;

        if(!$booked_rooms == null && !count($booked_rooms)>0) {
            //видалити разом з фото
            $photos = $room->photos;
            foreach ($photos as $photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
            }

            $photo = $room->photos()->delete();
            $room->delete();

            $response['status'] = true;
            $response['message'] = 'Кімнату успішно видалено';
            return $response;
        }

        $response['status'] = false;
        $response['message'] = 'Неможливо видалити кімнату, для неї є бронювання';
        return $response;
    }
}
