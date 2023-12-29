<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoomTranslations extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'amenities', 'price', 'count_bed', 'count_seats_in_bed', 'count_rooms', 'room_id', 'lang_code'];

    public function language() {
        return $this->belongsTo(Language::class, 'lang_code', 'code');
    }

    public function room() {
        return $this->belongsTo(Room::class, 'room_id', 'id');
    }
}
