<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Room\StoreRoomRequest;

use App\Models\Room;
use App\Models\Photo;

class StoreRoomController extends Controller
{
    public function index(StoreRoomRequest $request) {
        $user = Auth::user();
        $hotel = $user->hotel;

        $data = $request->validated();

        $room = new Room($data);

        $user->rooms()->save($room);

        $room->fresh();

        if($request->hasFile('room_photos')) {
            $photos = $request->room_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'room_photos'];

            for($i=0;$i<count($photos);$i++) {

                $fileName = time() . '_' . $photos[$i]->hashName();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
            }
        }

        return $room;
    }
}
