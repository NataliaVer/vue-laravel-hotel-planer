<?php

namespace App\Listeners;

use App\Events\EditedHotel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Models\Language;
use App\Models\Hotel;
use Stichoza\GoogleTranslate\GoogleTranslate;

class TranslationOfEditHotelData
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(EditedHotel $event): void
    {
        $exclude_el = ['number_house', 'phone', 'time_of_settlement', 'time_of_eviction', 'lang_code', 'baground_photo', 'all_photos'];
        $languages = Language::all();
        $lang_code = $event->translation->lang_code;
        $hotel = $event->translation->hotel;
        $translations = $hotel->translations;
        $data = $event->translation->toArray();
        unset($data['id']);


        foreach($languages as $lang) {
            foreach($translations as $translation) {
                if($lang->code != $lang_code && $translation->lang_code == $lang->code) {
                $data['lang_code'] = $lang->code;
                foreach($data as $key => $el){
                    if(!in_array($key, $exclude_el)) {
                        $result = is_array($el)? $el : GoogleTranslate::trans(strval($el), $lang->code=='ua'?'uk':$lang->code, $lang_code=='ua'?'uk':$lang_code);
                        $data[$key] = $result;
                    }
                }
                $translation->update($data);
            }
        }
        }
    }
}
