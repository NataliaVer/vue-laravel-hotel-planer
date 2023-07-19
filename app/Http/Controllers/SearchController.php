<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchCity(Request $req) {
        // $validation = $req->validate([
        //     'city' => 'required|mim:3|max:50']);
        $city = $req->get('nameCity');

        $hotels = Hotel::select('city', 'settlement')->where('city','like', $city.'%')
                                    ->OrWhere('settlement', 'like', $city.'%')
                                    ->groupBy('city', 'settlement')
                                    ->orderBy('city')
                                    ->get();

        $response['status'] = count($hotels)>0 ? true : false;
        $response['cities'] = $hotels;

        return response()->json($response);
    }

    public function searchHotels(Request $req) {
        $city = $req->get('nameCity');
        $dateFrom = $req->get('dateFrom');
        $dateTo = $req->get('dateTo');
        // $count_adult = $req->post('count_adult');
        // $count_children = $req->post('count_children');
        
        if (!$city) {
            $response['status'] = false;
            $response['message'] = 'Укажіть місто';

            return response()->json($response, 422);
        }

        if (!$dateFrom || !$dateTo) {
            $response['status'] = false;
            $response['message'] = 'Заповнять дати бажаного бронювання';

            return response()->json($response, 422);
        }

        $all_hotels_id = DB::table('hotels')->where('city','like', $city.'%')
                                         ->selectRaw('id as userhotel_id');

        $hotels = DB::table('hotels')->where('city','like', $city.'%')
                                    ->leftJoinSub($all_hotels_id, 'all_id_hotel', function ($join) {
                                        $join->on('hotels.id', '=', 'all_id_hotel.userhotel_id');
                                    })
                                    // ->leftJoin('users', 'hotels.user_id', '=', 'users.id')
                                    ->leftJoin('photos', function ($join) {
                                        $join->on('hotels.id', '=', 'photos.hotel_id')
                                             ->where('photos.kind_photo', '=', 'baground_photo');
                                    })
                                    ->orderBy('city')
                                    ->get();

                                    // dd($hotels);

        if (count($hotels)<1) {
            $response['status'] = false;
            $response['message'] = 'За вашим запитом не знайдено жодного готеля';

            return response()->json($response, 422);
        }
        
        $response['status'] = true;
        $response['hotels'] = $hotels;

        $newJSON = response()->json($response);
        return $newJSON;
    }
}
