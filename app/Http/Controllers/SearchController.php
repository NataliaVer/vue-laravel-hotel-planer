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
                                    ->paginate(20);
                                    // ->get();

        // $response['status'] = count($hotels)>0 ? true : false;
        // $response['cities'] = $hotels;

        return response()->json($hotels);
    }

    public function searchHotels(Request $req) {
        $city = $req->get('nameCity');
        $dateFrom = $req->get('dateFrom');
        $dateTo = $req->get('dateTo');
        // $count_adult = $req->post('count_adult');
        // $count_children = $req->post('count_children');
        
        if (!$city) {
            $response['status'] = false;
            $response['message'] = 'Please, specify the city';

            return response()->json($response);
        }

        if (!$dateFrom || !$dateTo) {
            $response['status'] = false;
            $response['message'] = 'Fill in the desired reservation dates';

            return response()->json($response);
        }

        //We get min price of rooms, at first we get hotels with condition,
        //becouse we need not all rooms, if it will be match, we get slow query
        $all_hotels_id = DB::table('hotels')->where('city','like', $city.'%')
                                            ->leftJoin('rooms', function ($join) {
                                                    $join->on('hotels.id', '=', 'rooms.hotel_id');
                                                })
                                            ->select(DB::raw('min(price) as min_price, hotel_id'))
                                            ->groupBy('hotel_id');

        $hotels = DB::table('hotels')->where('hotels.city','like', $city.'%')
                                    ->leftJoinSub($all_hotels_id, 'all_id_hotel', function ($join) {
                                        $join->on('hotels.id', '=', 'all_id_hotel.hotel_id');
                                    })
                                    ->leftJoin('photos', function ($join) {
                                        $join->on('hotels.id', '=', 'photos.hotel_id')
                                             ->where('photos.kind_photo', '=', 'baground_photo');
                                    })
                                    ->select('hotels.*', 'photos.photo', 'photos.kind_photo', 'photos.hotel_id', 'min_price')
                                    ->orderBy('city')
                                    // ->get();
                                    ->paginate(10);

        if (count($hotels)<1) {
            $response['status'] = false;
            $response['message'] = 'No hotel was found for your request';

            return response()->json($response);
        }
        
        $response['status'] = true;
        $response['hotels'] = $hotels;

        $newJSON = response()->json($response);
        return $newJSON;
    }
}
