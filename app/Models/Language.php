<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    use HasFactory;

    protected $fillable = ['code', 'name'];

    public function HotelTranslations() {
        return $this->hasMany(HotelTranslations::class, 'hotel_id', 'id');
    }

    public function RoomTranslations() {
        return $this->hasMany(HotelTranslations::class, 'room_id', 'id');
    }
}
