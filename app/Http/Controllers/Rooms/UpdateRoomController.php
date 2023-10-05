<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

use App\Models\Photo;
use App\Models\Room;

use App\Http\Requests\Room\UpdateRoomRequest;

class UpdateRoomController extends Controller
{
    public function index(UpdateRoomRequest $request, Room $room) {

        $user = Auth::user();
        $hotel = $user->hotel;

        $data = $request->validated();

        //dd($data);

        $room->update($data);

            if($request->hasFile('room_photos')) {

            $photos = $request->room_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'room_photos'];


            $photos_base = $room->photos;
            foreach ($photos_base as $photo) {

                if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
            }

            // $photo = $user->photos()->where('kind_photo', 'room_photos')->where('room_id', $room->id)->delete();
            $photo = $room->photos()->delete();

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
