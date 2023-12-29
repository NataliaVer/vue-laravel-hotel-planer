<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Models\Photo;
use App\Models\Hotel;
use App\Models\Language;
use App\Events\EditedHotel;
use Stichoza\GoogleTranslate\GoogleTranslate;

use App\Http\Requests\Hotel\UpdateHotelRequest;

class UpdateHotelController extends Controller
{
    public function index(UpdateHotelRequest $request, Hotel $hotel) {

        $user = Auth::user();

        $lang_code = $request->post('lang_code');

        $data = $request->validated();

        $hotel->update($data);

        $translate = $hotel->translate($lang_code);
        $translate->update($data);

        event(new EditedHotel($translate));

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
                $path = str_replace('/storage/', '',$photo->photo);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
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
                $path = str_replace('/storage/', '',$photo->photo);
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
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
