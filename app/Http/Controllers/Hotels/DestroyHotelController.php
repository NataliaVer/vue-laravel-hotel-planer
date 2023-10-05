<?php

namespace App\Http\Controllers\Hotels;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

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
                    if (File::exists(mb_substr($photo->photo,1))) {
                        unlink(public_path($photo->photo));
                    }
                }
                $room->photos()->delete();
            }

            $hotel->rooms()->delete();
            $hotel->photos()->delete();
            $hotel->delete();

            // return redirect()->route('userhotel');
            $response['status'] = true;
            $response['message'] = 'Готель успішно видалено';
            return $response;
        }
        
        // return back()->withErrors([
        //         'message' => 'Неможливо видалити готель, для нього є бронювання'
        //     ]);
        $response['status'] = false;
        $response['message'] = 'Неможливо видалити готель, для нього є бронювання';
        return $response;

    }
}
