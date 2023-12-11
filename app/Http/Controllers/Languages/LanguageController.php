<?php

namespace App\Http\Controllers\Languages;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Language;
use App\Models\Hotel;
use Illuminate\Support\Facades\DB;

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
}
