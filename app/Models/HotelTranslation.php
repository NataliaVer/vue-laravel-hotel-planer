<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelTranslation extends Model
{
    use HasFactory;

    protected $fillable = ['hotel_name', 'country', 'city', 'settlement', 'street', 'number_house', 'phone', 'aditional_services', 'description', 'time_of_settlement', 'time_of_eviction', 'hotel_id', 'lang_code'];

    public function language() {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }

    public function hotel() {
        return $this->belongsTo(Hotel::class, 'hotel_id', 'id');
    }
}
