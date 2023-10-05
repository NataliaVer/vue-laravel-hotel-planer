<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Photo;
use App\Models\Hotel;

use App\Http\Requests\Hotel\UpdateHotelRequest;

class UpdateHotelController extends Controller
{
    public function index(UpdateHotelRequest $request, Hotel $hotel) {

        // return $request->all();

        $user = Auth::user();

        $data = $request->validated();

        $hotel->update($data);

        if($request->hasFile('baground_photo')) {
            
            $photoData = [
                'user_id' => $user->id,
                'hotel_id' => $hotel->id,
                'photo' => '',
                'kind_photo' => 'baground_photo'];
            $fileName = time().$request->file('baground_photo')->hashName();
            $path = $request->file('baground_photo')->storeAs('images', $fileName, 'public');
            $photoData['photo'] = '/storage/'.$path;

            $photo = $user->photos()->where('kind_photo', 'baground_photo')->first();
            //опрацювати видалення файлів
            if($photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                    unlink(public_path($photo->photo));
                }
                $photo->update($photoData);
            } else {
                Photo::create($photoData);
            }
        }
        if($request->hasFile('all_photos')) {
            
            $photos = $request->all_photos;
            $photoData = [
                    'user_id' => $user->id,
                    'hotel_id' => $hotel->id,
                    'photo' => '',
                    'kind_photo' => 'all_photos'];

            $photos_old = $user->photos()->where('kind_photo', 'all_photos')->get();

            foreach ($photos_old as $photo) {
                if (File::exists(mb_substr($photo->photo,1))) {
                    unlink(public_path($photo->photo));
                }
            }
            $photos_old_del = $user->photos()->where('kind_photo', 'all_photos')->delete();

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
