<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Hotel;
use App\Models\HotelTranslations;
use App\Models\Language;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
    public function searchCity(Request $req) {
        // $validation = $req->validate([
        //     'city' => 'required|mim:3|max:50']);
        $city = $req->get('nameCity');
        $lang = $req->get('lang');
        // $lang = Language::select('id')->where('code', 'like', $lang)->first();

        $hotels = HotelTranslations::select('city', 'settlement')->where('lang_code', $lang)
                                    ->where(function ($query) use($city){
                                        $query->where('city','like', $city.'%')
                                              ->OrWhere('settlement', 'like', $city.'%');
                                    })
                                    ->groupBy('city', 'settlement')
                                    ->orderBy('city')
                                    ->paginate(20);


        return response()->json($hotels);
    }

    //in this function need to add count of people
    //who want to book the room
    public function searchHotels(Request $req) {
        $city = $req->get('nameCity');
        $dateFrom = $req->get('dateFrom');
        $dateTo = $req->get('dateTo');
        $langs = Language::all();
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
        $all_hotels_id = DB::table('hotel_translations')->where('city','like', $city.'%')
                                            ->leftJoin('rooms', function ($join) {
                                                    $join->on('hotel_translations.hotel_id', '=', 'rooms.hotel_id');
                                                })
                                            ->select(DB::raw('min(price) as min_price, hotel_translations.hotel_id'))
                                            ->groupBy('hotel_translations.hotel_id');
                                            // ->get();

        $queries = [];
        foreach($langs as $lang) {
            ${"all_hotels_$lang->code"} = DB::table('hotel_translations')->where('lang_code', $lang->code)
                                          ->joinSub($all_hotels_id ,'all_hotels_id', function ($join) {
                                              $join->on('hotel_translations.hotel_id', '=', 'all_hotels_id.hotel_id');
                                          })
                                        ->select('hotel_translations.hotel_id',
                                        "hotel_name as hotel_name_$lang->code",
                                        "aditional_services as aditional_services_$lang->code",
                                        "city as city_$lang->code",
                                        "country as country_$lang->code",
                                        "description as description_$lang->code",
                                        "number_house as number_house_$lang->code",
                                        "phone as phone_$lang->code",
                                        "settlement as settlement_$lang->code",
                                        "street as street_$lang->code",
                                        "time_of_eviction as time_of_eviction_$lang->code",
                                        "time_of_settlement as time_of_settlement_$lang->code")
                                        ->groupBy('hotel_translations.id');
        }

        $hotels = DB::table('hotels')->JoinSub($all_hotels_id, 'all_id_hotel', function ($join) {
                                        $join->on('hotels.id', '=', 'all_id_hotel.hotel_id');
                                    })
                                    ->leftJoinSub($all_hotels_en, 'all_hotels_en', function ($join) {
                                        $join->on('hotels.id', 'all_hotels_en.hotel_id');
                                    })
                                    ->leftJoinSub($all_hotels_ua, 'all_hotels_ua', function ($join) {
                                        $join->on('hotels.id', 'all_hotels_ua.hotel_id');
                                    })
                                    ->leftJoin('photos', function ($join) {
                                        $join->on('hotels.id', '=', 'photos.hotel_id')
                                             ->where('photos.kind_photo', '=', 'baground_photo');
                                        })
                                    ->select('all_hotels_en.*', 'all_hotels_ua.*', 'all_id_hotel.min_price', 'photos.photo', 'photos.kind_photo', 'photos.hotel_id', 'min_price')
                                    ->paginate(10);
                                    // ->get();

        // return $hotels;

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
