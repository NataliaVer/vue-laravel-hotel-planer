<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Hotel\StoreHotelRequest;
use App\Models\Photo;

class StoreHotelController extends Controller
{
    public function index(StoreHotelRequest $request) {

        $user = Auth::user();

        $data = $request->validated();

        $hotel = $user->hotel()->create($data);
        $hotel->fresh();

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
