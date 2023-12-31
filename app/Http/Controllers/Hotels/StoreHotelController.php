<?php

namespace App\Http\Controllers\Hotels;

use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Models\Photo;
use App\Models\Language;
use App\Events\AddedHotel;

class StoreHotelController extends Controller
{
    public function index(StoreHotelRequest $request) {

        $user = Auth::user();

        $lang_code = $request->post('lang_code');

        $data = $request->validated();
        // $exclude_el = ['number_house', 'phone', 'time_of_settlement', 'time_of_eviction', 'lang_code', 'baground_photo', 'all_photos'];

        $hotel = $user->hotel()->create($data);
        $hotel->fresh();

        $translate = $hotel->translations()->create($data);


        event(new AddedHotel($translate));

        if($request->hasFile('baground_photo')) {

            $photoData = [
                'user_id' => $user->id,
                'hotel_id' => $hotel->id,
                'photo' => '',
                'kind_photo' => 'baground_photo'];
            $fileName = time().$request->file('baground_photo')->hashName();
            $path = $request->file('baground_photo')->storeAs('images', $fileName, 'public');
            $photoData['photo'] = '/storage/'.$path;

            Photo::create($photoData);

        }

        if($request->hasFile('all_photos')) {

            $photos = $request->all_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'all_photos'];

            for($i=0;$i<count($photos);$i++) {
                $fileName = time() . '_' . $photos[$i]->hashName();
                $path = $photos[$i]->storeAs('images', $fileName, 'public');
                $photoData['photo'] = '/storage/'.$path;
                Photo::create($photoData); //createMany
            }

        }

        return $hotel;
    }
}
