<?php

namespace App\Http\Controllers\Rooms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

use App\Models\Photo;
use App\Models\Room;
use App\Models\Language;
use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Http\Requests\Room\UpdateRoomRequest;

class UpdateRoomController extends Controller
{
    public function index(UpdateRoomRequest $request, Room $room) {

        $user = Auth::user();
        $hotel = $user->hotel;

        $lang_code = $request->post('lang_code');

        $data = $request->validated();

        //dd($data);

        $room->update($data);

        $translate = $room->translate($lang_code);
        // return $translate;
        $translate->update($data);

        $translations = $room->translations;

        $include_el = ['name', 'description', 'amenities'];
        $languages = Language::all();

        foreach($languages as $lang) {
            foreach($translations as $translation) {
            if($lang->code != $lang_code && $translation->lang_code == $lang->code) {
                $data['lang_code'] = $lang->code;
                foreach($data as $key => $el){
                    if(in_array($key, $include_el)) {
                        $result = is_array($el)? $el : GoogleTranslate::trans(strval($el), $lang->code=='ua'?'uk':$lang->code, $lang_code=='ua'?'uk':$lang_code);
                        $data[$key] = $result;
                    }
                }
                $translation->update($data);
            }
        }
        }

            if($request->hasFile('room_photos')) {

            $photos = $request->room_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'room_id' => $room->id,
                    'hotel_id' => $hotel[0]->id,
                    'photo' => '',
                    'kind_photo' => 'room_photos'];


            $photos_base = $room->photos;
            foreach ($photos_base as $photo) {

                $path = str_replace('/storage/', '',$photo->photo);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
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
