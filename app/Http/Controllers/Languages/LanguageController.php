<?php

namespace App\Http\Controllers\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Hotel;
use App\Models\HotelTranslation;
use Illuminate\Support\Facades\DB;

use Stichoza\GoogleTranslate\GoogleTranslate;

class LanguageController extends Controller
{
    //list of languages
    public function index() {
        $lang = Language::all();

        return $lang;
    }

    public function getTranslateOfHotel($hotel_id, $lang) {
        $hotel = Hotel::find($hotel_id);
        $translate = $hotel->translations;
        return $translate;
    }

    //тут потрібно буде створити таблицю в базі даних
    //для списку міст з їхніми перекладами і звідти уже брати дані
    public function translateCity($lang, $city) {
        // return $lang." ".$city;
        $translate = '';
        $hotel = HotelTranslation::where('city', $city)->first();
        if($hotel) {
            $translate = HotelTranslation::where('hotel_id', $hotel->hotel_id)
                                        ->where('lang_code', $lang)
                                        ->value('city');
            return $translate;
        } else {
            $hotel = HotelTranslation::where('settlement', $city)->first();
            $translate = HotelTranslation::where('hotel_id', $hotel->hotel_id)
                                        ->where('lang_code', $lang)
                                        ->value('settlement');
        }
        return $translate;
    }
}
