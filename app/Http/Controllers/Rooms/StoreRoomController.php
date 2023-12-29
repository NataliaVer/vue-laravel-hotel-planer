<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests\Room\StoreRoomRequest;

use App\Models\Room;
use App\Models\Photo;
use App\Models\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;

class StoreRoomController extends Controller
{
    public function index(StoreRoomRequest $request) {
        $user = Auth::user();
        $hotel = $user->hotel->first();

        $lang_code = $request->post('lang_code');

        $data = $request->validated();

        $room = new Room($data);
        // $data['count_bed'] = $data['count_one_bed'];
        // $data['count_seats_in_bed'] = $data['count_two_bed'];
        $data['hotel_id'] = $hotel->id;

        // return $data;

        $room = $user->rooms()->create($data);

        //translation
        $translate = $room->translations()->create($data);

        $include_el = ['name', 'description', 'amenities'];
        $languages = Language::all();

        foreach($languages as $lang) {
            if($lang->code != $lang_code) {
                $data['lang_code'] = $lang->code;
                foreach($data as $key => $el){
                    if(in_array($key, $include_el)) {
                        $result = is_array($el)? $el : GoogleTranslate::trans(strval($el), $lang->code=='ua'?'uk':$lang->code, $lang_code=='ua'?'uk':$lang_code);
                        $data[$key] = $result;
                    }
                }
                $translate = $room->translations()->create($data);
            }
        }

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
