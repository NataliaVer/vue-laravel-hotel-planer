<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'hotel_name', 'country', 'city', 'settlement', 'street', 'number_house', 'phone', 'aditional_services', 'description', 'time_of_settlement', 'time_of_eviction', 'language'];

    public function rooms() {
        return $this->hasMany(Room::class, 'hotel_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function photos() {
        return $this->hasMany(Photo::class, 'hotel_id', 'id');
    }

    public function translations() {
        return $this->hasMany(HotelTranslations::class, 'hotel_id', 'id');
    }

    public function translate($langId) {
        return $this->translations()->where('language_id', $langId)->first();
    }
}
