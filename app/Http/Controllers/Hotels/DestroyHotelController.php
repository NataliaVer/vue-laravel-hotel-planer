<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DestroyHotelController extends Controller
{
    public function index(Hotel $hotel) {
        //видалити готель можна, якщо для нього не створено бронювань,
        //тут можна буде зробити розділення прав, і додати можливість
        //видалення всіх данних, лише для адміна

        //спочатку перевіримо чи є бронювання на даному готелі
        $room_ids = $hotel->rooms->pluck('id')->toArray();
        $booked_rooms = DB::table('booked_rooms')->whereIn('room_id', $room_ids)
                                                 ->count();
        // dd($booked_rooms);

        if(!$booked_rooms>0) {
            //видалити разом з фото
            $rooms = $hotel->rooms;

            foreach ($rooms as $room) {
                $photos = $hotel->photos;
                foreach ($photos as $photo) {
                    $path = str_replace('/storage/', '',$photo->photo);
                    if (Storage::disk('public')->exists($path)) {
                        Storage::disk('public')->delete($path);
                    }
                }
                $room->photos()->delete();
            }

            foreach($hotel->rooms as $room) {
                if(count($room->translations) > 0) {
                    $room->translations()->delete();
                }
            }

            $hotel->rooms()->delete();
            $hotel->photos()->delete();
            $hotel->translations()->delete();
            $hotel->delete();

            // return redirect()->route('userhotel');
            $response['status'] = true;
            $response['message'] = 'Hotel was deleted success';
            return $response;
        }
        
        // return back()->withErrors([
        //         'message' => 'Неможливо видалити готель, для нього є бронювання'
        //     ]);
        $response['status'] = false;
        $response['message'] = 'It is not possible to remove the hotel, it has a reservation';
        return response($response, 422);

    }
}
